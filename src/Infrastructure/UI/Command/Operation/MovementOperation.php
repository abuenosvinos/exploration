<?php

namespace App\Infrastructure\UI\Command\Operation;

use App\Application\GetMissionControl\GetMissionControlQuery;
use App\Application\MoveExplorer\MoveExplorerCommand;
use App\Domain\Entity\MissionControl;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovementOperation implements Operation
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private array $movements = ['F','L','R'];

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function actions(): array
    {
        return $this->movements;
    }

    public function attend(string $input): bool
    {
        return (strlen($input) === strspn($input,"FLR"));
    }

    public function run(string $input, SymfonyStyle $io): void
    {
        $idMovement = Uuid::random();
        $this->commandBus->dispatch(new MoveExplorerCommand($idMovement, $input));

        /** @var MissionControl $missionControl */
        $missionControl = $this->queryBus->ask(new GetMissionControlQuery());

        $noteBinnacle = $missionControl->getNoteBinnacle($idMovement->value());
        if (isset($noteBinnacle)) {
            $io->caution($noteBinnacle);
        }

        $io->writeln(sprintf(
            '%s safe at position (%s / %s) looking at %s',
            $missionControl->explorer()->name(),
            $missionControl->positionExplorer()->x(),
            $missionControl->positionExplorer()->y(),
            $missionControl->directionExplorer()->direction()
        ));
        $io->writeln('');
    }
}
