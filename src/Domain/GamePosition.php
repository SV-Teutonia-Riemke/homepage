<?php

declare(strict_types=1);

namespace App\Domain;

enum GamePosition: string
{
    case GOAL_KEEPER   = 'goal_keeper';
    case FAR_LEFT      = 'far_left';
    case HALF_LEFT     = 'half_left';
    case CENTER        = 'center';
    case HALF_RIGHT    = 'half_right';
    case FAR_RIGHT     = 'far_right';
    case CIRCLE_RUNNER = 'circle_runner';
}
