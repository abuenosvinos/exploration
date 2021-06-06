<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Planet;

interface PlanetRepository
{
    public function get(string $codePlanet): Planet;
}