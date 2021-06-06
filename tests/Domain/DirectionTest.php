<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Entity\Direction;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    public function testValidValues()
    {
        $direction = Direction::create('W');
        $this->assertEquals($direction->direction(), 'W');

        $direction = Direction::create(Direction::NORTH);
        $this->assertEquals($direction->direction(), Direction::NORTH);
    }

    public function testNotValidValues()
    {
        $this->expectException(InvalidArgumentException::class);

        Direction::create('WHATEVER');
    }
}