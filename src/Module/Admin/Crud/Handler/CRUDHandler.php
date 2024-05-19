<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud\Handler;

trait CRUDHandler
{
    use ListHandler;
    use CreateHandler;
    use EditHandler;
    use RemoveHandler;
}
