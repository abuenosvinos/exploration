<?php

namespace App\Domain\Repository;

use App\Domain\Entity\MissionControl;

interface MissionControlRepository
{
    public function get(): MissionControl;

    public function store(MissionControl $missionControl): void;

}