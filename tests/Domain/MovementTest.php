<?php

declare(strict_types=1);

namespace App\Tests;

use App\Domain\Entity\Movement;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MovementTest extends TestCase
{
    public function testValidValues()
    {
        $movement = Movement::create('R');
        $this->assertEquals($movement->movement(), 'R');

        $movement = Movement::create(Movement::LEFT);
        $this->assertEquals($movement->movement(), Movement::LEFT);
    }

    public function testNotValidValues()
    {
        $this->expectException(InvalidArgumentException::class);

        Movement::create('WHATEVER');
    }
}