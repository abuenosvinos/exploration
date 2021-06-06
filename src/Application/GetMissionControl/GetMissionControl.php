<?php

declare(strict_types = 1);

namespace App\Application\GetMissionControl;

use App\Domain\Repository\MissionControlRepository;

final class GetMissionControl
{
    private MissionControlRepository $repository;

    public function __construct(MissionControlRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->repository->get();
    }
}
