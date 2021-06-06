<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\InMemory;

use App\Domain\Exception\NotPlanetFoundException;
use App\Infrastructure\Persistence\InMemory\InMemoryPlanetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryPlanetRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        parent::setUp();
    }

    public function testValidValues()
    {
        $planetRepository = new InMemoryPlanetRepository(self::$kernel->getContainer());

        $planet = $planetRepository->get('MARTE');

        $this->assertEquals($planet->name(), 'Marte');

    }

    public function testNotValidCodePlanet()
    {
        $this->expectException(NotPlanetFoundException::class);

        $planetRepository = new InMemoryPlanetRepository(self::$kernel->getContainer());

        $planetRepository->get('WHATEVER');
    }
}