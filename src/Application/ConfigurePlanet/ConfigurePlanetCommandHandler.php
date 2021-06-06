<?php

declare(strict_types = 1);

namespace App\Application\ConfigurePlanet;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class ConfigurePlanetCommandHandler implements CommandHandler
{
    private ConfigurePlanet $configurePlanet;

    public function __construct(ConfigurePlanet $configurePlanet)
    {
        $this->configurePlanet = $configurePlanet;
    }

    public function __invoke(ConfigurePlanetCommand $command)
    {
        $codePlanet = $command->codePlanet();

        $this->configurePlanet->__invoke($codePlanet);
    }
}
