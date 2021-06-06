<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Shared\Domain\ValueObject\Enum;
use InvalidArgumentException;

class Movement extends Enum
{
    const FORWARD = 'F';
    const LEFT = 'L';
    const RIGHT = 'R';

    public static function create(string $movement)
    {
        return new self($movement);
    }

    public function movement(): string
    {
        return $this->value();
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException(sprintf('%s is not a valid movement', $value));
    }
}