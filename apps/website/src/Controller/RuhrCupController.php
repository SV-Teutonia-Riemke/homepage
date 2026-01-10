<?php

declare(strict_types=1);

namespace App\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ruhr-cup', name: 'ruhr_cup', options: ['sitemap' => true])]
final class RuhrCupController extends AbstractController
{
    public function __invoke(): RedirectResponse
    {
        return $this->redirect('https://ruhr-cup.de/');
    }
}
