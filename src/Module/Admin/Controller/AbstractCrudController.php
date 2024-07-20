<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Form\Type\Forms\AbstractForm;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\PositionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
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
use function sprintf;

/** @template Entity of object */
abstract class AbstractCrudController extends AbstractController
{
    /** @var CrudConfig<Entity>|null */
    private CrudConfig|null $crudConfig = null;

    public function handleList(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig($request);
        $form       = null;

        $list = $this->doLoadList($crudConfig);
        if ($list instanceof QueryBuilder) {
            $this->doConfigureQueryBuilder($list, $request);
        }

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

        return $this->render($crudConfig->getListTemplateName(), [
            'crud' => $crudConfig,
            'form' => $form ?? null,
            'iterable' => $pagination,
        ]);
    }

    protected function handleCreate(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig($request);

        $formType = $this->getFormType($request);

        $formOptions = [];

        if ($crudConfig->formEmptyDataCallable !== null) {
            $formOptions['empty_data'] = $crudConfig->formEmptyDataCallable;
        }

        $form = $this
            ->createForm($formType, null, $formOptions)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidCreateForm($request, $form);
        }

        return $this->render($crudConfig->getCreateTemplateName(), [
            'crud' => $crudConfig,
            'form' => $form,
        ]);
    }

    public function handleEdit(Request $request): Response
    {
        $crudConfig = $this->getCrudConfig($request);

        $object = $this->loadObject($request);

        $formType = $this->getFormType($request, $object);

        $form = $this
            ->createForm($formType, $this->doMapToFormDto($object))
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidEditForm($request, $form);
        }

        return $this->render($crudConfig->getEditTemplateName(), [
            'crud' => $crudConfig,
            'form' => $form,
            'object' => $object,
        ]);
    }

    private function handleValidCreateForm(
        Request $request,
        FormInterface $form,
    ): Response {
        return $this->handleValidForm(
            $request,
            $form,
            $this->doHandleValidCreateForm(...),
        );
    }

    private function handleValidEditForm(
        Request $request,
        FormInterface $form,
    ): Response {
        return $this->handleValidForm(
            $request,
            $form,
            $this->doHandleValidEditForm(...),
        );
    }

    private function handleValidForm(
        Request $request,
        FormInterface $form,
        callable $callable,
    ): Response {
        $data       = $form->getData();
        $crudConfig = $this->getCrudConfig($request);

        $callable($request, $form, $data);

        $this->addFlash('success', 'Daten wurden erfolgreich gespeichert');

        if ($form->has(AbstractForm::BUTTON_SUBMIT_AND_NEW)) {
            $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
            assert($submitAndNew instanceof SubmitButton);

            if ($submitAndNew->isClicked()) {
                return $this->redirectToRoute(
                    $crudConfig->getCreateRouteName(),
                    $crudConfig->getDefaultRouteParams(),
                );
            }
        }

        return $this->redirectToRoute(
            $crudConfig->getListRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    public function handleRemove(Request $request): Response
    {
        $entity     = $this->loadObject($request);
        $crudConfig = $this->getCrudConfig($request);

        $this->doRemoving($entity);

        $this->addFlash('success', 'Erfolgreich gelöscht');

        return $this->redirectToRoute(
            $crudConfig->getListRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    public function handleEnabled(
        Request $request,
        bool $enabled,
    ): Response {
        $entity = $this->loadObject($request);
        if (! $entity instanceof EnabledInterface) {
            throw $this->createNotFoundException();
        }

        $entity->setEnabled($enabled);

        $this->doPersisting($entity);

        if ($enabled) {
            $this->addFlash('success', 'Erfolgreich aktiviert');
        } else {
            $this->addFlash('success', 'Erfolgreich deaktiviert');
        }

        $crudConfig = $this->getCrudConfig($request);

        return $this->redirectToRoute(
            $crudConfig->getListRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    public function handlePosition(
        Request $request,
        int $position,
    ): Response {
        $entity = $this->loadObject($request);
        if (! $entity instanceof PositionInterface) {
            throw $this->createNotFoundException();
        }

        $entity->increasePosition($position);

        $this->doPersisting($entity);

        $crudConfig = $this->getCrudConfig($request);

        return $this->redirectToRoute(
            $crudConfig->getListRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    /** @return Entity */
    protected function loadObject(Request $request): object
    {
        $objectIdentifier = $request->get('object');
        if ($objectIdentifier === null) {
            throw new RuntimeException('Object identifier is not set', 1715881423158);
        }

        $crudConfig = $this->getCrudConfig($request);

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

    /** @param CrudConfig<Entity> $crudConfig */
    protected function doLoadList(CrudConfig $crudConfig): mixed
    {
        return $this->getEntityManager()->getRepository($crudConfig->dtoClass)->createQueryBuilder('p');
    }

    protected function doConfigureQueryBuilder(
        QueryBuilder $queryBuilder,
        Request $request,
    ): void {
    }

    /**
     * @param CrudConfig<Entity> $crudConfig
     *
     * @return Entity|null
     */
    protected function doLoadObject(
        CrudConfig $crudConfig,
        string|int $objectIdentifier,
    ): object|null {
        $entity = $this->getEntityManager()->getRepository($crudConfig->dtoClass)->find($objectIdentifier);
        if ($entity === null) {
            return null;
        }

        if (! is_a($entity, $crudConfig->dtoClass)) {
            throw new LogicException(sprintf('Entity is not an instance of %s', $crudConfig->dtoClass), 1716117092970);
        }

        return $entity;
    }

    /** @param Entity $object */
    protected function doMapToFormDto(object $object): mixed
    {
        return $object;
    }

    protected function doHandleValidCreateForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        $this->doHandleValidForm($request, $form, $data);
    }

    protected function doHandleValidEditForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        $this->doHandleValidForm($request, $form, $data);
    }

    protected function doHandleValidForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        $this->doPersisting($data);
    }

    /** @param Entity $object */
    protected function doCreatePersisting(object $object): void
    {
        $this->doPersisting($object);
    }

    /** @param Entity $object */
    protected function doUpdatePersisting(object $object): void
    {
        $this->doPersisting($object);
    }

    /** @param Entity $object */
    protected function doPersisting(object $object): void
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /** @param Entity $object */
    protected function doRemoving(object $object): void
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected function enrichPaginationOptions(
        Request $request,
        array $options,
    ): array {
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
    final protected function getCrudConfig(Request $request): CrudConfig
    {
        if ($this->crudConfig === null) {
            /** @var CrudConfigBuilder<Entity> $builder */
            $builder = new CrudConfigBuilder();
            $this->configureCrudConfig($builder, $request);

            $this->crudConfig = $builder->build();
        }

        return $this->crudConfig;
    }

    /** @param CrudConfigBuilder<Entity> $builder */
    abstract protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void;

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
