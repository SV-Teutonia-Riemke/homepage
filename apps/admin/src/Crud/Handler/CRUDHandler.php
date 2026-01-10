<?php

declare(strict_types=1);

namespace App\Admin\Crud\Handler;

trait CRUDHandler
{
    use ListHandler;
    use CreateHandler;
    use EditHandler;
    use RemoveHandler;
}
