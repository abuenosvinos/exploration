<?php

namespace App\Infrastructure\UI\Controller;

use App\Application\GetMissionControl\GetMissionControlQuery;
use App\Domain\Entity\MissionControl;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StatusController
{
    public function home(UrlGeneratorInterface $router): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $router->generate('status', [], UrlGenerator::ABSOLUTE_URL)
            ]
        );
    }

    public function status(QueryBus $queryBus): JsonResponse
    {
        /** @var MissionControl $missionControl */
        $missionControl = $queryBus->ask(new GetMissionControlQuery());

        $status = [
            'planet' => [
                'name' => $missionControl->planet()->name(),
                'length' => $missionControl->planet()->length(),
                'height' => $missionControl->planet()->height(),
            ],
            'explorer' => [
                'name' => $missionControl->explorer()->name(),
                'x' => $missionControl->positionExplorer()->latitude(),
                'y' => $missionControl->positionExplorer()->longitude(),
                'direction' => $missionControl->directionExplorer()->direction()
            ]
        ];

        return new JsonResponse(
            $status
        );
    }
}