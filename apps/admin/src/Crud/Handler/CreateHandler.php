<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait CreateHandler
{
    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        return $this->handleCreate($request);
    }
}
