<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class Position
{
    private int $x;
    private int $y;

    private function __construct(int $x, int $y)
    {
        if ($x < 0) {
            throw new InvalidArgumentException(sprintf('The value x of a Position has to be a positive value (%s)', $x));
        }
        if ($y < 0) {
            throw new InvalidArgumentException(sprintf('The value y of a Position has to be a positive value (%s)', $y));
        }

        $this->x = $x;
        $this->y = $y;
    }

    public static function create(int $x, int $y)
    {
        return new self($x, $y);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }
}