<?php

declare(strict_types = 1);

namespace App\Application\MoveExplorer;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\ValueObject\Uuid;

final class MoveExplorerCommand extends Command
{
    private Uuid $idMovement;
    private string $movementChain;

    public function __construct(Uuid $idMovement, string $movementChain)
    {
        parent::__construct();

        $this->idMovement = $idMovement;
        $this->movementChain = $movementChain;
    }

    public function idMovement(): Uuid
    {
        return $this->idMovement;
    }

    public function movementChain(): string
    {
        return $this->movementChain;
    }
}
