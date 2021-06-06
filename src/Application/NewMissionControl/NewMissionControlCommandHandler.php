<?php

declare(strict_types = 1);

namespace App\Application\NewMissionControl;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class NewMissionControlCommandHandler implements CommandHandler
{
    private NewMissionControl $newMissionControl;

    public function __construct(NewMissionControl $newMissionControl)
    {
        $this->newMissionControl = $newMissionControl;
    }

    public function __invoke(NewMissionControlCommand $command)
    {
        $this->newMissionControl->__invoke(
            $command->codePlanet(),
            $command->nameExplorer(),
            $command->positionExplorer(),
            $command->directionExplorer()
        );
    }
}
