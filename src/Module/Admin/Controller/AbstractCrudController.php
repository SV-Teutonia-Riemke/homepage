<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\CrudHandlingHelper;
use App\Module\Admin\Form\Type\Forms\AbstractForm;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\PositionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use RuntimeException;
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

        if ($crudConfig->hasSearchType()) {
            $form = $this->createForm($crudConfig->getSearchType());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $crudConfig->runHandlePreFiltering($form);
            }
        }

        $list = $crudConfig->runListLoader($request);

        if ($form !== null && $form->isSubmitted() && $form->isValid()) {
            $crudConfig->runHandlePostFiltering($form, $list);
        }

        $paginationOptions = $crudConfig->runHandlePaginationOptions($request, [
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

        $form = $this
            ->createForm($crudConfig->getFormType($request))
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
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

        $formType = $crudConfig->getFormType($request, $object);

        $form = $this
            ->createForm($formType, $object)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->render($crudConfig->editTemplate, [
            'form' => $form,
            'object' => $object,
        ]);
    }

    private function handleValidForm(FormInterface $form): Response
    {
        $data       = $form->getData();
        $crudConfig = $this->getCrudConfig();

        $crudConfig->runHandleForm($form, $data);
        $crudConfig->runPersisting($data);

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

        $crudConfig->runHandleRemoving($entity);

        return $this->redirectToRoute($crudConfig->listRouteName);
    }

    public function handleEnabled(Request $request, bool $enabled): Response
    {
        $entity = $this->loadObject($request);
        if (! $entity instanceof EnabledInterface) {
            throw $this->createNotFoundException();
        }

        $entity->setEnabled($enabled);

        $crudConfig = $this->getCrudConfig();

        $crudConfig->runPersisting($entity);

        return $this->redirectToRoute($crudConfig->listRouteName);
    }

    public function handlePosition(Request $request, int $position): Response
    {
        $entity = $this->loadObject($request);
        if (! $entity instanceof PositionInterface) {
            throw $this->createNotFoundException();
        }

        $entity->increasePosition($position);

        $crudConfig = $this->getCrudConfig();

        $crudConfig->runPersisting($entity);

        return $this->redirectToRoute($crudConfig->listRouteName);
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

        $entity = $crudConfig->getRepository($this->getEntityManager())->find($objectIdentifier);
        if ($entity === null || ! is_a($entity, $dtoClass)) {
            throw $this->createNotFoundException();
        }

        return $entity;
    }

    /** @return CrudConfig<Entity> */
    final protected function getCrudConfig(): CrudConfig
    {
        if ($this->crudConfig === null) {
            /** @var CrudConfigBuilder<Entity> $builder */
            $builder = new CrudConfigBuilder(
                $this->getCrudHandlingHelper(),
            );
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

    private function getPaginator(): PaginatorInterface
    {
        return $this->container->get(PaginatorInterface::class);
    }

    /** @return CrudHandlingHelper<Entity> */
    private function getCrudHandlingHelper(): CrudHandlingHelper
    {
        return $this->container->get(CrudHandlingHelper::class);
    }

    /** @inheritDoc */
    public static function getSubscribedServices(): array
    {
        $services = parent::getSubscribedServices();

        return array_merge($services, [
            EntityManagerInterface::class,
            PaginatorInterface::class,
            CrudHandlingHelper::class,
        ]);
    }
}
