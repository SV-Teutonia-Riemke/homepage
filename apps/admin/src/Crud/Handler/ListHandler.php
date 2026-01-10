<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait ListHandler
{
    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->handleList($request);
    }
}
