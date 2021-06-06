<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Entity\Obstacle;
use App\Domain\Entity\Planet;
use App\Domain\Exception\NotPlanetFoundException;
use App\Domain\Repository\PlanetRepository;
use App\Domain\Entity\Position;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InMemoryPlanetRepository implements PlanetRepository
{
    private array $planets;
    private array $dataPlanets;

    public function __construct(ContainerInterface $container)
    {
        $this->planets = [];
        $this->dataPlanets = $container->getParameter('planets');
    }

    public function get(string $codePlanet): Planet
    {
        if (!isset($this->planets[$codePlanet])) {
            $this->planets[$codePlanet] = $this->loadPlanetFromCode($codePlanet);
        }
        return $this->planets[$codePlanet];
    }

    private function loadPlanetFromCode(string $codePlanet): Planet
    {
        if (!isset($this->dataPlanets[$codePlanet])) {
            throw new NotPlanetFoundException($codePlanet);
        }

        $data = $this->dataPlanets[$codePlanet];

        $obstacles = [];
        foreach ($data['obstacles'] as $obstacle) {
            $obstacles[] = Obstacle::create(Position::create($obstacle['x'], $obstacle['y']));
        }

        return Planet::create(
            $data['name'],
            $data['length'],
            $data['height'],
            $obstacles
        );
    }

}