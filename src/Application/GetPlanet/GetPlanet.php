<?php

declare(strict_types = 1);

namespace App\Application\GetPlanet;

use App\Domain\Repository\PlanetRepository;

final class GetPlanet
{
    private PlanetRepository $repository;

    public function __construct(PlanetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $codePlanet)
    {
        return $this->repository->get($codePlanet);
    }
}
