<?php

declare(strict_types=1);

namespace App\Module\Admin\Twig\Component;

use App\Module\Admin\Form\Type\Forms\PersonGroupType;
use App\Storage\Entity\PersonGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(
    'admin_person_group_form',
    '@admin/_components/person_group_form.html.twig',
)]
final class PersonGroupFormComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(fieldName: 'data')]
    public PersonGroup|null $personGroup;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            PersonGroupType::class,
            $this->personGroup,
        );
    }

    #[LiveAction]
    public function addMember(): void
    {
        $this->formValues['members'][] = [];
    }

    #[LiveAction]
    public function removeMember(
        #[LiveArg] int $index,
    ): void {
        unset($this->formValues['members'][$index]);
    }
}
