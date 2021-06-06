<?php

declare(strict_types = 1);

namespace App\Application\NewMissionControl;

use App\Domain\Entity\Direction;
use App\Domain\Entity\Explorer;
use App\Domain\Entity\MissionControl;
use App\Domain\Entity\Position;
use App\Domain\Repository\MissionControlRepository;
use App\Domain\Repository\PlanetRepository;
use App\Shared\Domain\Bus\Event\EventBus;

final class NewMissionControl
{
    private MissionControlRepository $missionControlRepository;
    private PlanetRepository $planetRepository;
    private EventBus $eventBus;

    public function __construct(MissionControlRepository $missionControlRepository, PlanetRepository $planetRepository, EventBus $eventBus)
    {
        $this->missionControlRepository = $missionControlRepository;
        $this->planetRepository = $planetRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(string $codePlanet, string $nameExplorer, Position $positionExplorer, Direction $directionExplorer)
    {
        $planet = $this->planetRepository->get($codePlanet);

        $missionControl = MissionControl::create(
            $planet,
            Explorer::factory($nameExplorer),
            $positionExplorer,
            $directionExplorer
        );

        $this->missionControlRepository->store($missionControl);

        $this->eventBus->notify(...[new ExplorerHasLanded(['missionControl' => $missionControl])]);
    }
}
