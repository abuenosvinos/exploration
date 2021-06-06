<?php

declare(strict_types = 1);

namespace App\Application\GetPlanet;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class GetPlanetQueryHandler implements QueryHandler
{
    private GetPlanet $getPlanet;

    public function __construct(GetPlanet $getPlanet)
    {
        $this->getPlanet = $getPlanet;
    }

    public function __invoke(GetPlanetQuery $query)
    {
        return $this->getPlanet->__invoke($query->codePlanet());
    }
}
