<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class Position
{
    private int $latitude;
    private int $longitude;

    private function __construct(int $latitude, int $longitude)
    {
        if ($latitude < 0) {
            throw new InvalidArgumentException(sprintf('The latitude of a Position has to be a positive value (%s)', $latitude));
        }
        if ($longitude < 0) {
            throw new InvalidArgumentException(sprintf('The longitude of a Position has to be a positive value (%s)', $longitude));
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public static function create(int $latitude, int $longitude)
    {
        return new self($latitude, $longitude);
    }

    public function latitude(): int
    {
        return $this->latitude;
    }

    public function longitude(): int
    {
        return $this->longitude;
    }
}