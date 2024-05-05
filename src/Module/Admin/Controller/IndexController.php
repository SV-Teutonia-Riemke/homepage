<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/', name: 'index')]
final class IndexController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('@admin/index.html.twig');
    }
}
