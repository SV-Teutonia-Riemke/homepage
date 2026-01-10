<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait EditHandler
{
    #[Route('/{object}/edit', name: 'edit')]
    public function edit(Request $request): Response
    {
        return $this->handleEdit($request);
    }
}
