<?php

declare(strict_types=1);

namespace App\Domain\Entity\Explorer;

use App\Domain\Entity\Explorer;

final class Curiosity extends Explorer
{
    public static function create(): Curiosity
    {
        return new self('Curiosity');
    }
}