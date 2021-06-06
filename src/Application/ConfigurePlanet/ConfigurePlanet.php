<?php

declare(strict_types = 1);

namespace App\Application\ConfigurePlanet;

use App\Domain\Repository\PlanetRepository;

final class ConfigurePlanet
{
    private PlanetRepository $planetRepository;

    public function __construct(PlanetRepository $planetRepository)
    {
        $this->planetRepository = $planetRepository;
    }

    public function __invoke(string $codePlanet)
    {
        return $this->planetRepository->get($codePlanet);
    }
}
