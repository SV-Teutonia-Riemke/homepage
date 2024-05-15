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
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function assert;

/** @template Entity typeof object */
abstract class AbstractCrudController extends AbstractController
{
    /** @var CrudConfig<Entity>|null */
    private CrudConfig|null $crudConfig = null;

    public function handleList(Request $request): Response
    {
        $crudConfig = $this->getCrudConfigObject();
        $form       = null;

        if ($crudConfig->hasSearchType()) {
            $form = $this->createForm($crudConfig->getSearchType());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() && $crudConfig->handlePreFiltering !== null) {
                ($crudConfig->handlePreFiltering)($form);
            }
        }

        $list = ($crudConfig->listLoader)($crudConfig, $request);

        if ($form !== null && $form->isSubmitted() && $form->isValid() && $crudConfig->handlePostFiltering !== null) {
            ($crudConfig->handlePostFiltering)($form, $list);
        }

        $paginationOptions = [];
        if ($this->getCrudConfigObject()->defaultSortFieldName !== null) {
            $paginationOptions['defaultSortFieldName'] = $this->getCrudConfigObject()->defaultSortFieldName;
        }

        if ($this->getCrudConfigObject()->defaultSortDirection !== null) {
            $paginationOptions['defaultSortDirection'] = $this->getCrudConfigObject()->defaultSortDirection;
        }

        if ($crudConfig->handlePaginationOptions !== null) {
            $paginationOptions = ($crudConfig->handlePaginationOptions)($request, $paginationOptions);
        }

        $pagination = $this->getPaginator()->paginate(
            $list,
            $request->query->getInt('page', 1),
            options: $paginationOptions,
        );

        return $this->render($this->getCrudConfigObject()->listTemplate, [
            'form' => $form ?? null,
            'iterable' => $pagination,
        ]);
    }

    protected function handleCreate(Request $request): Response
    {
        $form = $this
            ->createForm($this->getCrudConfigObject()->getFormType($request))
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->render($this->getCrudConfigObject()->createTemplate, [
            'form' => $form,
        ]);
    }

    public function handleEdit(Request $request): Response
    {
        $object = $this->loadObject($request);

        $form = $this
            ->createForm($this->getCrudConfigObject()->getFormType($request, $object), $object)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->render($this->getCrudConfigObject()->editTemplate, [
            'form' => $form,
            'object' => $object,
        ]);
    }

    private function handleValidForm(FormInterface $form): Response
    {
        $data = $form->getData();

        $callable = $this->getCrudConfigObject()->handleForm;
        if ($callable !== null) {
            $callable($form, $data);
        }

        ($this->getCrudConfigObject()->handlePersisting)($data);

        if ($form->has(AbstractForm::BUTTON_SUBMIT_AND_NEW)) {
            $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
            assert($submitAndNew instanceof SubmitButton);

            if ($submitAndNew->isClicked()) {
                return $this->redirectToRoute($this->getCrudConfigObject()->createRouteName);
            }
        }

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handleRemove(Request $request): Response
    {
        ($this->getCrudConfigObject()->handleRemoving)(
            $this->loadObject($request),
        );

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handleEnabled(Request $request, bool $enabled): Response
    {
        $entity = $this->loadObject($request);

        if (! $entity instanceof EnabledInterface) {
            throw $this->createNotFoundException();
        }

        $entity->setEnabled($enabled);

        ($this->getCrudConfigObject()->handlePersisting)($entity);

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handlePosition(Request $request, int $position): Response
    {
        $entity = $this->loadObject($request);

        if (! $entity instanceof PositionInterface) {
            throw $this->createNotFoundException();
        }

        $entity->increasePosition($position);

        ($this->getCrudConfigObject()->handlePersisting)($entity);

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    protected function loadObject(Request $request): object
    {
        $entity = $this->getEntityManager()->getRepository($this->getCrudConfigObject()->dtoClass)->find($request->get('object'));
        if ($entity === null) {
            throw $this->createNotFoundException();
        }

        return $entity;
    }

    /** @return CrudConfig<Entity> */
    final protected function getCrudConfigObject(): CrudConfig
    {
        if ($this->crudConfig === null) {
            $builder = new CrudConfigBuilder($this->getCrudHandlingHelper());
            $this->configureCrudConfig($builder);

            $this->crudConfig = $builder->build();
        }

        return $this->crudConfig;
    }

    abstract protected function configureCrudConfig(CrudConfigBuilder $builder): void;

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->container->get(EntityManagerInterface::class);
    }

    private function getPaginator(): PaginatorInterface
    {
        return $this->container->get(PaginatorInterface::class);
    }

    private function getFilterBuilderUpdater(): FilterBuilderUpdaterInterface
    {
        return $this->container->get(FilterBuilderUpdaterInterface::class);
    }

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
            FilterBuilderUpdaterInterface::class,
            CrudHandlingHelper::class,
        ]);
    }
}
