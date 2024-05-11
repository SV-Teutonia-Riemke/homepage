<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/ruhr-cup', name: 'ruhr_cup', options: ['sitemap' => true])]
final class RuhrCupController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirect('https://ruhr-cup.de/');
    }
}
