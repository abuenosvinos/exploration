<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class Planet
{
    private string $name;
    private int $length;
    private int $height;
    private array $obstacles;
    private array $map;

    public function __construct(string $name, int $length, int $height, array $obstacles)
    {
        $this->name = $name;
        $this->length = $length;
        $this->height = $height;
        $this->obstacles = $obstacles;

        /** @var Obstacle $obstacle */
        foreach ($obstacles as $obstacle) {
            if ($obstacle->position()->x() > $length || $obstacle->position()->y() > $height) {
                throw new InvalidArgumentException(sprintf('The Position of an obstacle (%s / %s) is outside the surface of the planet (%s / %s)', $obstacle->position()->x(), $obstacle->position()->y(), $length, $height));
            }

            $this->map[$obstacle->position()->x()][$obstacle->position()->y()] = $obstacle;
        }
    }

    public static function create(string $name, int $length, int $height, array $obstacles): Planet
    {
        return new self($name, $length, $height, $obstacles);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function length(): int
    {
        return $this->length;
    }

    public function obstacles(): array
    {
        return $this->obstacles;
    }

    public function hasAnObstacle(Position $position): bool
    {
        return isset($this->map[$position->x()][$position->y()]);
    }

    public function minHeight(): int
    {
        return 0;
    }

    public function maxHeight(): int
    {
        return ($this->height - 1);
    }

    public function minLength(): int
    {
        return 0;
    }

    public function maxLength(): int
    {
        return ($this->length - 1);
    }
}