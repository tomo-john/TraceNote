<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;
use App\Models\Tag;
use App\Enums\TraceStatus;

class DashboardService
{
    public function getStats(User $user): array
    {
        return [
            'traceCount' => $user->traces()->count(),

            'tagCount' => $user->tags()->count(),

            'statusCount' => $user->traces()
                                  ->selectRaw('status, count(*) as count')
                                  ->groupBy('status')
                                  ->pluck('count', 'status')
                                  ->toArray(),
        ];
    }
}
