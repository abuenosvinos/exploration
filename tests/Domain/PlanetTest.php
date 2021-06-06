<?php

declare(strict_types=1);

namespace App\Tests;

use App\Domain\Entity\Obstacle;
use App\Domain\Entity\Planet;
use App\Domain\Entity\Position;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PlanetTest extends TestCase
{
    public function testValidValues()
    {
        $planet = Planet::create(
            'test',
            10,
            12,
            [Obstacle::create(Position::create(5, 5))]
        );

        $this->assertEquals($planet->name(), 'test');
        $this->assertEquals($planet->length(), 10);
        $this->assertEquals($planet->height(), 12);
    }

    public function testObstacleOutByHeight()
    {
        $this->expectException(InvalidArgumentException::class);

        Planet::create(
            'test',
            10,
            12,
            [Obstacle::create(Position::create(15, 5))]
        );
    }

    public function testObstacleOutByLength()
    {
        $this->expectException(InvalidArgumentException::class);

        Planet::create(
            'test',
            10,
            12,
            [Obstacle::create(Position::create(5, 15))]
        );
    }

    public function testObstacles()
    {
        $planet = Planet::create(
            'test',
            20,
            20,
            [
                Obstacle::create(Position::create(5, 5)),
                Obstacle::create(Position::create(10, 10)),
                Obstacle::create(Position::create(15, 15)),
            ]
        );

        $this->assertTrue($planet->hasAnObstacle(Position::create(5, 5)));
        $this->assertTrue($planet->hasAnObstacle(Position::create(10, 10)));
        $this->assertTrue($planet->hasAnObstacle(Position::create(15, 15)));
        $this->assertFalse($planet->hasAnObstacle(Position::create(3, 7)));
        $this->assertFalse($planet->hasAnObstacle(Position::create(7, 3)));
    }
}