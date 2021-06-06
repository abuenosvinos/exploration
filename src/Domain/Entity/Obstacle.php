<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Obstacle
{
    private Position $position;

    private function __construct(Position $position)
    {
        $this->position = $position;
    }

    public static function create(Position $position)
    {
        return new self($position);
    }

    public function position(): Position
    {
        return $this->position;
    }
}