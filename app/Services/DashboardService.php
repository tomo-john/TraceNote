<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;
use App\Models\Tag;
use App\Enums\TraceStatus;

class DashboardService
{
    // Trace数
    private function getTraceCount(User $user): int
    {
        return $user->traces()->count();
    }

    // Tag数
    private function getTagCount(User $user): int
    {
        return $user->tags()->count();
    }

    // ステータスごと集計
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

    // 最近のTrace
    private function getRecentTraces(User $user)
    {
        return $user->traces()
            ->latest()
            ->take(5)
            ->get();
    }

    // 活動記録
    private function getActivityCounts(User $user): array
    {
        return $user->traces()
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->pluck('count', 'date')
            ->toArray();

    }

    // 検証用
    private function getTest(User $user): array
    {
        return collect(range(0, 4))->map(fn ($days) => now()->subDays($days)->format('Y-m-d'))->toArray();
    }

    // コントローラーから呼び出すのはこれだけ
    public function getStats(User $user): array
    {
        return [
            'traceCount' => $this->getTraceCount($user),
            'tagCount' => $this->getTagCount($user),
            'statusCounts' => $this->getStatusCounts($user),
            'recentTraces' => $this->getRecentTraces($user),
            'activityCounts' => $this->getActivityCounts($user),
            'test' => $this->getTest($user),
        ];
    }
}
