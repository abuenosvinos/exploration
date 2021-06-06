<?php

namespace App\Infrastructure\UI\Command\Operation;

use Symfony\Component\Console\Style\SymfonyStyle;

class HelpOperation implements Operation
{
    public function actions(): array
    {
        return ['HELP'];
    }

    public function attend(string $input): bool
    {
        return (in_array($input, $this->actions()));
    }

    public function run(string $input, SymfonyStyle $io): void
    {
        $io->table(
            ['Command','Description'],
            [
                ['L','Turn the explorer to the left'],
                ['R','Turn the explorer to the right'],
                ['F','The explorer move forward'],
                ['LRFFLFRFRRL','Any combination of the movement commands'],
                ['NEW','Start the process to create a new Mission'],
                ['MAP','Show the visualization of the Planet included Obstacles and the Explorer'],
                ['HELP','Show this information'],
                ['EXIT','Exits the exploration'],
            ]
        );
    }
}
