<?php

declare(strict_types = 1);

namespace App\Application\NewMissionControl;

use App\Domain\Entity\Direction;
use App\Domain\Entity\Position;
use App\Shared\Domain\Bus\Command\Command;

final class NewMissionControlCommand extends Command
{
    private string $codePlanet;
    private string $nameExplorer;
    private Position $positionExplorer;
    private Direction $directionExplorer;

    public function __construct(string $codePlanet, string $nameExplorer, Position $positionExplorer, Direction $directionExplorer)
    {
        parent::__construct();

        $this->codePlanet = $codePlanet;
        $this->nameExplorer = $nameExplorer;
        $this->positionExplorer = $positionExplorer;
        $this->directionExplorer = $directionExplorer;
    }

    public function codePlanet(): string
    {
        return $this->codePlanet;
    }

    public function positionExplorer(): Position
    {
        return $this->positionExplorer;
    }

    public function directionExplorer(): Direction
    {
        return $this->directionExplorer;
    }

    public function nameExplorer(): string
    {
        return $this->nameExplorer;
    }
}
