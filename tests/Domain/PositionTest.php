<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Entity\Position;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testValidValues()
    {
        $position = Position::create(3, 7);
        $this->assertEquals($position->latitude(), 3);
        $this->assertEquals($position->longitude(), 7);
    }

    public function testNotValidValues()
    {
        $this->expectException(InvalidArgumentException::class);

        Position::create(-3, -4);
    }
}