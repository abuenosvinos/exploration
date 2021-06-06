<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Entity\Direction;
use App\Domain\Entity\MissionControl;
use App\Domain\Entity\Movement;
use App\Domain\Entity\Obstacle;
use App\Domain\Entity\Planet;
use App\Domain\Entity\Position;
use App\Domain\Entity\Explorer\Rover;
use App\Domain\Exception\ObstacleFoundException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MissionControlTest extends TestCase
{
    public function testValidValues()
    {
        $missionControl = MissionControl::create(
            Planet::create('test', 35, 45, []),
            Rover::create(),
            Position::create(5, 7),
            Direction::create(Direction::NORTH)
        );

        $this->assertEquals($missionControl->planet()->name(), 'test');
        $this->assertEquals($missionControl->planet()->length(), 35);
        $this->assertEquals($missionControl->planet()->height(), 45);
        $this->assertEquals($missionControl->positionExplorer()->x(), 5);
        $this->assertEquals($missionControl->positionExplorer()->y(), 7);
        $this->assertEquals($missionControl->directionExplorer()->direction(), Direction::NORTH);
    }

    public function testMovements()
    {
        $missionControl = MissionControl::create(
            Planet::create('test', 35, 45, []),
            Rover::create(),
            Position::create(5, 7),
            Direction::create(Direction::NORTH)
        );

        $missionControl->move(Movement::create(Movement::FORWARD));
        $this->assertEquals($missionControl->positionExplorer()->x(), 5);
        $this->assertEquals($missionControl->positionExplorer()->y(), 6);
        $this->assertEquals($missionControl->directionExplorer()->direction(), Direction::NORTH);

        $missionControl->move(Movement::create(Movement::LEFT));
        $this->assertEquals($missionControl->positionExplorer()->x(), 5);
        $this->assertEquals($missionControl->positionExplorer()->y(), 6);
        $this->assertEquals($missionControl->directionExplorer()->direction(), Direction::WEST);

        $missionControl->move(Movement::create(Movement::FORWARD));
        $this->assertEquals($missionControl->positionExplorer()->x(), 4);
        $this->assertEquals($missionControl->positionExplorer()->y(), 6);
        $this->assertEquals($missionControl->directionExplorer()->direction(), Direction::WEST);
    }

    public function testBadMovementOutOfPlanet()
    {
        $this->expectException(InvalidArgumentException::class);

        $missionControl = MissionControl::create(
            Planet::create('test', 35, 45, []),
            Rover::create(),
            Position::create(1, 1),
            Direction::create(Direction::NORTH)
        );

        $missionControl->move(Movement::create(Movement::FORWARD));
        $missionControl->move(Movement::create(Movement::FORWARD));
    }

    public function testBadMovementCrashWithObstacle()
    {
        $this->expectException(ObstacleFoundException::class);

        $missionControl = MissionControl::create(
            Planet::create('test', 50, 50, [Obstacle::create(Position::create(10, 10))]),
            Rover::create(),
            Position::create(7, 10),
            Direction::create(Direction::EAST)
        );

        $missionControl->move(Movement::create(Movement::FORWARD));
        $missionControl->move(Movement::create(Movement::FORWARD));
        $missionControl->move(Movement::create(Movement::FORWARD));
    }
}