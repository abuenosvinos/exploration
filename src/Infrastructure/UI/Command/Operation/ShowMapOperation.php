<?php

namespace App\Infrastructure\UI\Command\Operation;

use App\Application\GetMissionControl\GetMissionControlQuery;
use App\Domain\Entity\Direction;
use App\Domain\Entity\MissionControl;
use App\Domain\Entity\Obstacle;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowMapOperation implements Operation
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function actions(): array
    {
        return ['MAP'];
    }

    public function attend(string $input): bool
    {
        return (in_array($input, $this->actions()));
    }

    public function run(string $input, SymfonyStyle $io): void
    {
        /** @var MissionControl $missionControl */
        $missionControl = $this->queryBus->ask(new GetMissionControlQuery());
        $planet = $missionControl->planet();
        $explorer = $missionControl->explorer();
        $positionExplorer = $missionControl->positionExplorer();
        $directionExplorer = $missionControl->directionExplorer();

        $io->writeln(sprintf('Map of %s (%s / %s)', $planet->name(), $planet->length(), $planet->height()));

        $io->writeln(sprintf('%s at position (%s / %s) looking at %s', $explorer->name(), $positionExplorer->x(), $positionExplorer->y(), $directionExplorer->direction()));

        $matrix = [];
        for ($h=0; $h<$planet->height(); $h++) {
            $startMark = '|';
            $middleMark = ' ';
            $lastMark = '|';

            if ($h == $planet->minHeight() || $h == $planet->maxHeight()) {
                $startMark = '+';
                $middleMark = '-';
                $lastMark = '+';
            }

            for ($l=0; $l<$planet->length(); $l++) {
                if ($l == $planet->minLength()) $matrix[$h][$l] = $startMark;
                elseif ($l == $planet->maxLength()) $matrix[$h][$l] = $lastMark;
                else $matrix[$h][$l] = $middleMark;
            }
        }

        /** @var Obstacle $obstacle */
        foreach ($planet->obstacles() as $obstacle) {
            $matrix[$obstacle->position()->y()][$obstacle->position()->x()] = '<fg=red>X</>';
        }

        $matrix[$positionExplorer->y()][$positionExplorer->x()] = '<fg=green>'.$this->getSymbolDirection($directionExplorer).'</>';

        for ($h=0; $h<count($matrix); $h++) {
            for ($l=0; $l<count($matrix[$h]); $l++) {
                $io->write($matrix[$h][$l]);
            }

            $io->writeln('');
        }
    }

    private function getSymbolDirection(Direction $directionExplorer)
    {
        switch ($directionExplorer->direction()) {
            case Direction::WEST: return '←';
            case Direction::NORTH: return '↑'; // CTRL + SHIFT + U y luego 2191
            case Direction::EAST: return '→';
            case Direction::SOUTH: return '↓';
        }
    }
}
