<?php

declare(strict_types = 1);

namespace App\Application\MoveExplorer;

use App\Domain\Entity\Movement;
use App\Shared\Domain\Bus\Command\CommandHandler;

final class MoveExplorerCommandHandler implements CommandHandler
{
    private MoveExplorer $moveExplorer;

    public function __construct(MoveExplorer $moveExplorer)
    {
        $this->moveExplorer = $moveExplorer;
    }

    public function __invoke(MoveExplorerCommand $command)
    {
        $movementChain = $command->movementChain();

        $movements = [];
        foreach (str_split($movementChain) as $strMovement) {
            $movements[] = Movement::create($strMovement);
        }

        $this->moveExplorer->__invoke($command->idMovement(), $movements);
    }
}
