<?php

declare(strict_types=1);

namespace App\Twig\Component;

use App\Module\Admin\Form\Type\Forms\TeamType;
use App\Storage\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('admin_team_form')]
final class TeamFormComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Team $team;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            TeamType::class,
            $this->team
        );
    }

    #[LiveAction]
    public function addPlayer(): void
    {
        $this->formValues['players'][] = [];
    }

    #[LiveAction]
    public function removePlayer(
        #[LiveArg] int $index
    ): void {
        unset($this->formValues['players'][$index]);
    }

    #[LiveAction]
    public function addStaff(): void
    {
        $this->formValues['staffs'][] = [];
    }

    #[LiveAction]
    public function removeStaff(
        #[LiveArg] int $index
    ): void {
        unset($this->formValues['staffs'][$index]);
    }
}
