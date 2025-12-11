<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ruhr-cup', name: 'ruhr_cup', options: ['sitemap' => true])]
final class RuhrCupController extends AbstractController
{
    public function __invoke(): RedirectResponse
    {
        return $this->redirect('https://ruhr-cup.de/');
    }
}
