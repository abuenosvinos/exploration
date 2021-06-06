<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Explorer\Curiosity;
use App\Domain\Entity\Explorer\Rover;

abstract class Explorer
{
    private string $name;

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public static function factory(string $nameExplorer): Explorer
    {
        switch ($nameExplorer) {
            case 'ROVER': return Rover::create();
            case 'CURIOSITY': return Curiosity::create();
        }
    }
}