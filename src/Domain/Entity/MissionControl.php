<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\ObstacleFoundException;
use InvalidArgumentException;

class MissionControl
{
    private Planet $planet;
    private Explorer $explorer;
    private Position $positionExplorer;
    private Direction $directionExplorer;
    private array $binnacle;

    private function __construct(Planet $planet, Explorer $explorer, Position $positionExplorer, Direction $directionExplorer)
    {
        $this->planet = $planet;
        $this->explorer = $explorer;
        $this->positionExplorer = $positionExplorer;
        $this->directionExplorer = $directionExplorer;
        $this->binnacle = [];
    }

    public function planet(): Planet
    {
        return $this->planet;
    }

    public function explorer(): Explorer
    {
        return $this->explorer;
    }

    public function positionExplorer(): Position
    {
        return $this->positionExplorer;
    }

    public function directionExplorer(): Direction
    {
        return $this->directionExplorer;
    }

    public function addNoteBinnacle(string $id, string $msg): void
    {
        $this->binnacle[$id] = $msg;
    }

    public function getNoteBinnacle(string $id): ?string
    {
        return $this->binnacle[$id] ?? null;
    }

    public function move(Movement $movement): void
    {
        if ($movement->movement() === Movement::LEFT) {
            $this->directionExplorer = $this->moveLeft();
        } elseif ($movement->movement() === Movement::RIGHT) {
            $this->directionExplorer = $this->moveRight();
        } elseif ($movement->movement() === Movement::FORWARD) {
            $newPosition = $this->moveForward();

            if ($this->planet->hasAnObstacle($newPosition)) {
                throw new ObstacleFoundException($this->explorer, $newPosition);
            }

            $this->positionExplorer = $newPosition;
        }
    }

    private function moveLeft(): Direction
    {
        if ($this->directionExplorer->direction() === 'N') {
            return Direction::create('W');
        } elseif ($this->directionExplorer->direction() === 'W') {
            return Direction::create('S');
        } elseif ($this->directionExplorer->direction() === 'S') {
            return Direction::create('E');
        } elseif ($this->directionExplorer->direction() === 'E') {
            return Direction::create('N');
        }
    }

    private function moveRight(): Direction
    {
        if ($this->directionExplorer->direction() === 'N') {
            return Direction::create('E');
        } elseif ($this->directionExplorer->direction() === 'E') {
            return Direction::create('S');
        } elseif ($this->directionExplorer->direction() === 'S') {
            return Direction::create('W');
        } elseif ($this->directionExplorer->direction() === 'W') {
            return Direction::create('N');
        }
    }

    private function moveForward(): Position
    {
        try {
            if ($this->directionExplorer->direction() === 'N') {
                $newPosition = Position::create($this->positionExplorer->latitude(), $this->positionExplorer->longitude() - 1);
            } elseif ($this->directionExplorer->direction() === 'W') {
                $newPosition = Position::create($this->positionExplorer->latitude() - 1, $this->positionExplorer->longitude());
            } elseif ($this->directionExplorer->direction() === 'S') {
                $newPosition = Position::create($this->positionExplorer->latitude(), $this->positionExplorer->longitude() + 1);
            } elseif ($this->directionExplorer->direction() === 'E') {
                $newPosition = Position::create($this->positionExplorer->latitude() + 1, $this->positionExplorer->longitude());
            }
        } catch (InvalidArgumentException) {
            throw new InvalidArgumentException(sprintf('Not possible movement. %s can\'t fly', $this->explorer->name()));
        }

        if ($newPosition->latitude() < $this->planet->minHeight() ||
            $newPosition->longitude() < $this->planet->minLength() ||
            $newPosition->latitude() > $this->planet->maxLength() ||
            $newPosition->longitude() > $this->planet->maxHeight()) {
            throw new InvalidArgumentException(sprintf('Not possible movement. %s can\'t fly', $this->explorer->name()));
        }

        return $newPosition;
    }

    public static function create(Planet $planet, Explorer $explorer, Position $positionExplorer, Direction $directionExplorer): MissionControl
    {
        return new self($planet, $explorer, $positionExplorer, $directionExplorer);
    }
}