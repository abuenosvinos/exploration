<?php

namespace App\Infrastructure\UI\Command\Operation;

use App\Application\GetMissionControl\GetMissionControlQuery;
use App\Application\GetPlanet\GetPlanetQuery;
use App\Application\NewMissionControl\NewMissionControlCommand;
use App\Domain\Entity\Direction;
use App\Domain\Entity\MissionControl;
use App\Domain\Entity\Planet;
use App\Domain\Entity\Position;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewMissionOperation implements Operation
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private array $dataExplorers;
    private array $dataPlanets;

    public function __construct(CommandBus $commandBus,  QueryBus $queryBus, ContainerInterface $container)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->dataExplorers = $container->getParameter('explorers');
        $this->dataPlanets = $container->getParameter('planets');
    }

    public function actions(): array
    {
        return ['NEW'];
    }

    public function attend(string $input): bool
    {
        return (in_array($input, $this->actions()));
    }

    public function run(string $input, SymfonyStyle $io): void
    {
        $namePlanet = $this->askPlanetToLoad($io);
        /** @var Planet $planet */
        $planet = $this->queryBus->ask(new GetPlanetQuery($namePlanet));
        $explorer = $this->askExplorerToSend($io);
        $positionExplorer = null;
        while (!$positionExplorer) {
            $x = $this->askXPositionExplorerInPlanet($io, $planet);
            $y = $this->askYPositionExplorerInPlanet($io, $planet);
            $positionExplorer = Position::create($x, $y);
            if ($planet->hasAnObstacle($positionExplorer)) {
                $io->note('There is an Obstacle in that position, you need to choose other');
                $positionExplorer = null;
            }
        }
        $direction = $this->askDirectionInPlanet($io);

        $this->commandBus->dispatch(new NewMissionControlCommand($namePlanet, $explorer, $positionExplorer, Direction::create($direction)));

        /** @var MissionControl $missionControl */
        $missionControl = $this->queryBus->ask(new GetMissionControlQuery());
        $io->writeln(sprintf('%s has landed on (%s / %s) looking at %s', $missionControl->explorer()->name(), $missionControl->positionExplorer()->x(), $missionControl->positionExplorer()->y(), $missionControl->directionExplorer()->direction()));
        $io->writeln('');
    }

    private function askPlanetToLoad(SymfonyStyle $io)
    {
        $namePlanets = array_keys($this->dataPlanets);

        return $io->ask(sprintf('What planet do you want to explore (%s)?', implode(',', $namePlanets)), $namePlanets[0], function ($answer) use ($namePlanets) {
            if (!in_array($answer, $namePlanets)) {
                throw new \RuntimeException(
                    'The name of the planet is not valid'
                );
            }

            return $answer;
        });
    }

    private function askExplorerToSend(SymfonyStyle $io)
    {
        $namePlanets = array_keys($this->dataExplorers);

        return $io->ask(sprintf('What Explorer do you want to send (%s)?', implode(',', $namePlanets)), $namePlanets[0], function ($answer) use ($namePlanets) {
            if (!in_array($answer, $namePlanets)) {
                throw new \RuntimeException(
                    'The name of the Explorer is not valid'
                );
            }

            return $answer;
        });
    }

    private function askXPositionExplorerInPlanet(SymfonyStyle $io, Planet $planet)
    {
        return $io->ask(sprintf('At what latitude do you want the explorer to land  (%s)?', $planet->minLength() . ' - ' . $planet->maxLength()), null, function ($answer) use ($planet) {
            if (!isset($answer) || $answer < $planet->minLength() || $answer > $planet->maxLength()) {
                throw new \RuntimeException(
                    'The latitude value to land is not valid'
                );
            }
            return $answer;
        });
    }

    private function askYPositionExplorerInPlanet(SymfonyStyle $io, Planet $planet)
    {
        return $io->ask(sprintf('At what longitude do you want the explorer to land  (%s)?', $planet->minHeight() . ' - ' . $planet->maxHeight()), null, function ($answer) use ($planet) {
            if (!isset($answer) || $answer < $planet->minHeight() || $answer > $planet->maxHeight()) {
                throw new \RuntimeException(
                    'The longitude value to land is not valid'
                );
            }

            return $answer;
        });
    }

    private function askDirectionInPlanet(SymfonyStyle $io)
    {
        return $io->choice('At what direction do you want the explorer to land?', [Direction::EAST, Direction::SOUTH, Direction::WEST, Direction::NORTH]);
    }
}
