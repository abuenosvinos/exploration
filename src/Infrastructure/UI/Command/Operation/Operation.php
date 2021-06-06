<?php

namespace App\Infrastructure\UI\Command\Operation;

use Symfony\Component\Console\Style\SymfonyStyle;

interface Operation
{
    public function actions() : array;

    public function attend(string $input) : bool;

    public function run(string $input, SymfonyStyle $io) : void;
}
