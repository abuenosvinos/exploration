<?php

declare(strict_types = 1);

namespace App\Application\GetPlanet;

use App\Shared\Domain\Bus\Query\Query;

final class GetPlanetQuery extends Query
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
