<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Form\Type\Forms\AbstractForm;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\PositionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use RuntimeException;
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function array_filter;
use function array_merge;
use function assert;
use function class_exists;
use function is_a;

/** @template Entity of object */
abstract class AbstractCrudController extends AbstractController
{
    /** @var CrudConfig<Entity>|null */
    private CrudConfig|null $crudConfig = null;

    public function handleList(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig();
        $form       = null;

        $list = $this->doLoadList($crudConfig);

        $searchType = $this->getSearchType();
        if ($searchType !== null) {
            $form = $this->createForm($searchType);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getFilterBuilderUpdate()->addFilterConditions($form, $list);
            }
        }

        $paginationOptions = $this->enrichPaginationOptions($request, [
            'defaultSortFieldName' => $crudConfig->defaultSortFieldName,
            'defaultSortDirection' => $crudConfig->defaultSortDirection,
        ]);
        $paginationOptions = array_filter(
            $paginationOptions,
            static fn ($value) => $value !== null,
        );

        $pagination = $this->getPaginator()->paginate(
            $list,
            $request->query->getInt('page', 1),
            options: $paginationOptions,
        );

        return $this->render($crudConfig->listTemplate, [
            'form' => $form ?? null,
            'iterable' => $pagination,
        ]);
    }

    protected function handleCreate(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig();

        if ($crudConfig->createTemplate === null) {
            throw new RuntimeException('Create template is not set', 1715882067839);
        }

        $formType = $this->getFormType($request);

        $form = $this
            ->createForm($formType)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidCreateForm($request, $form);
        }

        return $this->render($crudConfig->createTemplate, [
            'form' => $form,
        ]);
    }

    public function handleEdit(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig();

        if ($crudConfig->editTemplate === null) {
            throw new RuntimeException('Edit template is not set', 1715881714899);
        }

        $object = $this->loadObject($request);

        $formType = $this->getFormType($request, $object);

        $form = $this
            ->createForm($formType, $object)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidEditForm($form);
        }

        return $this->render($crudConfig->editTemplate, [
            'form' => $form,
            'object' => $object,
        ]);
    }

    private function handleValidCreateForm(Request $request, FormInterface $form): Response
    {
        return $this->handleValidForm(
            $request,
            $form,
            $this->doHandleValidCreateForm(...),
        );
    }

    private function handleValidEditForm(Request $request, FormInterface $form): Response
    {
        return $this->handleValidForm(
            $request,
            $form,
            $this->doHandleValidEditForm(...),
        );
    }

    private function handleValidForm(Request $request, FormInterface $form, callable $callable): Response
    {
        $data       = $form->getData();
        $crudConfig = $this->getCrudConfig();

        $callable($request, $form, $data);

        if ($form->has(AbstractForm::BUTTON_SUBMIT_AND_NEW) && $crudConfig->createRouteName !== null) {
            $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
            assert($submitAndNew instanceof SubmitButton);

            if ($submitAndNew->isClicked()) {
                return $this->redirectToRoute($crudConfig->createRouteName);
            }
        }

        return $this->redirectToRoute($crudConfig->listRouteName);
    }

    public function handleRemove(Request $request): Response
    {
        $entity     = $this->loadObject($request);
        $crudConfig = $this->getCrudConfig();

        $this->doRemoving($entity);

        return $this->redirectToRoute($crudConfig->listRouteName);
    }

    public function handleEnabled(Request $request, bool $enabled): Response
    {
        $entity = $this->loadObject($request);
        if (! $entity instanceof EnabledInterface) {
            throw $this->createNotFoundException();
        }

        $entity->setEnabled($enabled);

        $this->doPersisting($entity);

        return $this->redirectToRoute($this->getCrudConfig()->listRouteName);
    }

    public function handlePosition(Request $request, int $position): Response
    {
        $entity = $this->loadObject($request);
        if (! $entity instanceof PositionInterface) {
            throw $this->createNotFoundException();
        }

        $entity->increasePosition($position);

        $this->doPersisting($entity);

        return $this->redirectToRoute($this->getCrudConfig()->listRouteName);
    }

    /** @return Entity */
    protected function loadObject(Request $request): object
    {
        $objectIdentifier = $request->get('object');
        if ($objectIdentifier === null) {
            throw new RuntimeException('Object identifier is not set', 1715881423158);
        }

        $crudConfig = $this->getCrudConfig();

        $dtoClass = $crudConfig->dtoClass;
        if (! class_exists($dtoClass)) {
            throw new RuntimeException('DTO class not found', 1715882288448);
        }

        $entity = $this->doLoadObject($crudConfig, $objectIdentifier);
        if ($entity === null || ! is_a($entity, $dtoClass)) {
            throw $this->createNotFoundException();
        }

        return $entity;
    }

    protected function doLoadList(CrudConfig $crudConfig): mixed
    {
        return $this->getEntityManager()->getRepository($crudConfig->dtoClass)->createQueryBuilder('p');
    }

    /** @return Entity|null */
    protected function doLoadObject(CrudConfig $crudConfig, mixed $objectIdentifier): object|null
    {
        return $this->getEntityManager()->getRepository($crudConfig->dtoClass)->find($objectIdentifier);
    }

    protected function doHandleValidCreateForm(Request $request, FormInterface $form, $data): void
    {
        $this->doHandleValidForm($request, $form, $data);
    }

    protected function doHandleValidEditForm(Request $request, FormInterface $form, $data): void
    {
        $this->doHandleValidForm($request, $form, $data);
    }

    protected function doHandleValidForm(Request $request, FormInterface $form, $data): void
    {
        $this->doPersisting($data);
    }

    protected function doCreatePersisting($object): void
    {
        $this->doPersisting($object);
    }

    protected function doUpdatePersisting($object): void
    {
        $this->doPersisting($object);
    }

    protected function doPersisting($object): void
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    protected function doRemoving($object): void
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    protected function enrichPaginationOptions(Request $request, array $options): array
    {
        return $options;
    }

    protected function getSearchType(): string|null
    {
        return null;
    }

    abstract protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string;

    /** @return CrudConfig<Entity> */
    final protected function getCrudConfig(): CrudConfig
    {
        if ($this->crudConfig === null) {
            /** @var CrudConfigBuilder<Entity> $builder */
            $builder = new CrudConfigBuilder();
            $this->configureCrudConfig($builder);

            $this->crudConfig = $builder->build();
        }

        return $this->crudConfig;
    }

    /** @param CrudConfigBuilder<Entity> $builder */
    abstract protected function configureCrudConfig(CrudConfigBuilder $builder): void;

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->container->get(EntityManagerInterface::class);
    }

    protected function getPaginator(): PaginatorInterface
    {
        return $this->container->get(PaginatorInterface::class);
    }

    protected function getFilterBuilderUpdate(): FilterBuilderUpdaterInterface
    {
        return $this->container->get(FilterBuilderUpdaterInterface::class);
    }

    /** @inheritDoc */
    public static function getSubscribedServices(): array
    {
        $services = parent::getSubscribedServices();

        return array_merge($services, [
            EntityManagerInterface::class,
            PaginatorInterface::class,
            FilterBuilderUpdaterInterface::class,
        ]);
    }
}
