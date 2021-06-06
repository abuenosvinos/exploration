<?php

namespace App\Domain\Exception;

class NotPlanetFoundException extends \LogicException
{
    public function __construct(string $codePlanet)
    {
        parent::__construct(sprintf('Planet %s not found', $codePlanet));
    }
}