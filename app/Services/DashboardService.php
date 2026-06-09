<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;
use App\Models\Tag;
use App\Enums\TraceStatus;

class DashboardService
{
    private function getStatusCounts(User $user): array
    {
        $counts = $user->traces()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return collect(TraceStatus::cases())
            ->map(fn (TraceStatus $status) => [
                'label' => $status->label(),
                'count' => $counts[$status->value] ?? 0,
                'colorClass' => $status->colorClass(),
                'iconClass' => $status->iconClass(),
            ])
            ->toArray();
    }

    public function getStats(User $user): array
    {
        return [
            'traceCount' => $user->traces()->count(),
            'tagCount' => $user->tags()->count(),
            'statusCounts' => $this->getStatusCounts($user),
        ];
    }
}
