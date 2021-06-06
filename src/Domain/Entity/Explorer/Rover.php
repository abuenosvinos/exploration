<?php

declare(strict_types=1);

namespace App\Domain\Entity\Explorer;

use App\Domain\Entity\Explorer;

final class Rover extends Explorer
{
    public static function create(): Rover
    {
        return new self('Rover');
    }
}