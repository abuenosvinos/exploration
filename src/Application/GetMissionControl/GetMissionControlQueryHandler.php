<?php

declare(strict_types = 1);

namespace App\Application\GetMissionControl;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class GetMissionControlQueryHandler implements QueryHandler
{
    private GetMissionControl $getMissionControl;

    public function __construct(GetMissionControl $getMissionControl)
    {
        $this->getMissionControl = $getMissionControl;
    }

    public function __invoke(GetMissionControlQuery $query)
    {
        return $this->getMissionControl->__invoke();
    }
}
