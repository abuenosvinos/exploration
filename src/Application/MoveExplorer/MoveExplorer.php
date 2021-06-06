<?php

declare(strict_types = 1);

namespace App\Application\MoveExplorer;

use App\Domain\Exception\ObstacleFoundException;
use App\Domain\Repository\MissionControlRepository;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;
use InvalidArgumentException;

final class MoveExplorer
{
    private MissionControlRepository $missionControlRepository;
    private EventBus $eventBus;

    public function __construct(MissionControlRepository $missionControlRepository, EventBus $eventBus)
    {
        $this->missionControlRepository = $missionControlRepository;
        $this->eventBus        = $eventBus;
    }

    public function __invoke(Uuid $idMovement, array $movements)
    {
        $missionControl = $this->missionControlRepository->get();

        try {
            foreach ($movements as $movement) {
                $missionControl->move($movement);
            }

        } catch (InvalidArgumentException $invalidArgumentException) {
            $missionControl->addNoteBinnacle($idMovement->value(), $invalidArgumentException->getMessage());
        } catch (ObstacleFoundException $obstacleFoundException) {
            $missionControl->addNoteBinnacle($idMovement->value(), $obstacleFoundException->getMessage());
        } finally {
            $this->missionControlRepository->store($missionControl);
            $this->eventBus->notify(...[new ExplorerWasMoved(['missionControl' => $missionControl])]);
        }
    }
}
