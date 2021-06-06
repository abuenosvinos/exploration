<?php

namespace App\Domain\Exception;

use App\Domain\Entity\Explorer;
use App\Domain\Entity\Position;

class ObstacleFoundException extends \LogicException
{
    public function __construct(Explorer $explorer, Position $position)
    {
        parent::__construct(sprintf('%s has found an obstacle at position (%s / %s)', $explorer->name(), $position->x(), $position->y()));
    }
}