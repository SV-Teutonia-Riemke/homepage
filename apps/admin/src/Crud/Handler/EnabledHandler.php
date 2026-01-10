<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait EnabledHandler
{
    #[Route('/{object}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{object}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(
        Request $request,
        bool $enabled,
    ): Response {
        return $this->handleEnabled($request, $enabled);
    }
}
