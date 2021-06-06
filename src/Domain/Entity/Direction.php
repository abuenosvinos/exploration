<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Shared\Domain\ValueObject\Enum;
use InvalidArgumentException;

class Direction extends Enum
{
    const WEST = 'W';
    const EAST = 'E';
    const NORTH = 'N';
    const SOUTH = 'S';

    public static function create(string $direction)
    {
        return new self($direction);
    }

    public function direction(): string
    {
        return $this->value();
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException(sprintf('%s is not a valid direction', $value));
    }
}