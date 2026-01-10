<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait RemoveHandler
{
    #[Route('/{object}/remove', name: 'remove')]
    public function remove(Request $request): Response
    {
        return $this->handleRemove($request);
    }
}
