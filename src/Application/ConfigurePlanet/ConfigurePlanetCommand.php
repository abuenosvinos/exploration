<?php

declare(strict_types = 1);

namespace App\Application\ConfigurePlanet;

use App\Shared\Domain\Bus\Command\Command;

final class ConfigurePlanetCommand extends Command
{
    private string $codePlanet;

    public function __construct(string $codePlanet)
    {
        parent::__construct();

        $this->codePlanet = $codePlanet;
    }

    public function codePlanet(): string
    {
        return $this->codePlanet;
    }
}
