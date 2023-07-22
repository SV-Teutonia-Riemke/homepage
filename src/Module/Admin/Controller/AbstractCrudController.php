<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
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

abstract class AbstractCrudController extends AbstractController
{
    private CrudConfig|null $crudConfig = null;

    public function handleList(Request $request): Response
    {
        $query = $this->getCrudConfigObject()->entityRepository->createQueryBuilder('p');

        $searchType = $this->getCrudConfigObject()->searchType;

        if ($searchType !== null) {
            $form = $this->createForm($searchType);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getFilterBuilderUpdater()->addFilterConditions($form, $query);
            }
        }

        $paginationOptions = [];

        if ($this->getCrudConfigObject()->defaultSortFieldName !== null) {
            $paginationOptions['defaultSortFieldName'] = $this->getCrudConfigObject()->defaultSortFieldName;
        }

        if ($this->getCrudConfigObject()->defaultSortDirection !== null) {
            $paginationOptions['defaultSortDirection'] = $this->getCrudConfigObject()->defaultSortDirection;
        }

        $pagination = $this->getPaginator()->paginate(
            $query,
            $request->query->getInt('page', 1),
            options: $paginationOptions,
        );

        return $this->render($this->getCrudConfigObject()->listTemplate, [
            'form'       => $form ?? null,
            'pagination' => $pagination,
        ]);
    }

    protected function handleCreate(Request $request): Response
    {
        $form = $this
            ->createForm($this->getCrudConfigObject()->formType)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->render($this->getCrudConfigObject()->createTemplate, [
            'form' => $form,
        ]);
    }

    public function handleEdit(Request $request, object $object): Response
    {
        $form = $this
            ->createForm($this->getCrudConfigObject()->formType, $object)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleValidForm($form);
        }

        return $this->render($this->getCrudConfigObject()->editTemplate, [
            'form'   => $form,
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

        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();

        if ($form->has(AbstractForm::BUTTON_SUBMIT_AND_NEW)) {
            $submitAndNew = $form->get(AbstractForm::BUTTON_SUBMIT_AND_NEW);
            assert($submitAndNew instanceof SubmitButton);

            if ($submitAndNew->isClicked()) {
                return $this->redirectToRoute($this->getCrudConfigObject()->createRouteName);
            }
        }

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handleRemove(object $data): Response
    {
        $this->getEntityManager()->remove($data);
        $this->getEntityManager()->flush();

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handleEnabled(EnabledInterface $data, bool $enabled): Response
    {
        $data->setEnabled($enabled);

        $this->getEntityManager()->flush();

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    public function handlePosition(PositionInterface $data, int $position): Response
    {
        $data->increasePosition($position);

        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->flush();

        return $this->redirectToRoute($this->getCrudConfigObject()->listRouteName);
    }

    final protected function getCrudConfigObject(): CrudConfig
    {
        if ($this->crudConfig === null) {
            $this->crudConfig = $this->getCrudConfig();
        }

        return $this->crudConfig;
    }

    abstract protected function getCrudConfig(): CrudConfig;

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
