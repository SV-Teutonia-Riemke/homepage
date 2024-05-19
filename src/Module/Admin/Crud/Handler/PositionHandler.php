<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

trait PositionHandler
{
    #[Route('/{object}/up', name: 'up', defaults: ['position' => -1])]
    #[Route('/{object}/down', name: 'down', defaults: ['position' => 1])]
    public function position(Request $request, int $position): Response
    {
        return $this->handlePosition($request, $position);
    }
}
