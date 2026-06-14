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
        // 日付の枠(昇順)
        $calendar =  collect(range(0, 30))->mapWithKeys(function ($days) {
            $date = now()->subDays($days)->format('Y-m-d');
            return [$date => 0];
        })->reverse();

        // DBから日付ごとにTraceの数をカウント
        $traceCounts = $user->traces()
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->pluck('count', 'date');

        // マージした配列を返す
        return $calendar->merge($traceCounts)
                        ->map(fn ($count, $date) => [
                            'date' => $date,
                            'count' => $count,
                            'colorClass' => $this->getActivityColorClass($count),
                        ])
                        ->values()
                        ->toArray();
    }

    private function getActivityColorClass(int $count): string
    {
        return match (true) {
            $count === 0 => 'bg-slate-100',
            $count <= 2 => 'bg-green-200',
            $count <= 3 => 'bg-green-300',
            $count <= 4 => 'bg-green-400',
            $count <= 5 => 'bg-green-500',
            $count >= 6 => 'bg-green-700',
            default => 'bg-slate-100'
        };
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
        ];
    }
}
