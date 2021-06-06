<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Entity\MissionControl;
use App\Domain\Repository\MissionControlRepository;

class InMemoryMissionControlRepository implements MissionControlRepository
{
    private MissionControl $missionControl;

    public function get(): MissionControl
    {
        return $this->missionControl;
    }

    public function store(MissionControl $missionControl): void
    {
        $this->missionControl = $missionControl;
    }
}