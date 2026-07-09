<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;
use App\Models\Tag;
use App\Enums\TraceStatus;

class DashboardService
{
    private const ACTIVITY_DAYS = 167; // Activity Historyの日数

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
        // 日付の枠
        $startDate = now()->endOfWeek()->subDays(self::ACTIVITY_DAYS);

        $calendar =  collect(range(0, self::ACTIVITY_DAYS))->mapWithKeys(function ($days) use ($startDate) {
            $date = $startDate->copy()
                              ->addDays($days)
                              ->format('Y-m-d');
            return [$date => 0];
        });

        // DBから日付ごとにTraceの数をカウント
        $traceCounts = $user->traces()
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', $startDate)
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
            $count === 0 => 'bg-slate-400',
            $count <= 2 => 'bg-green-200',
            $count <= 3 => 'bg-green-300',
            $count <= 4 => 'bg-green-400',
            $count <= 5 => 'bg-green-500',
            default => 'bg-green-700'
        };
    }

    // 表示用の犬
    private function getDogInfo(User $user): array
    {
        $traceCount = $this->getTraceCount($user);

        return match (true) {
            $traceCount < 10 => [
                'colorClass' => 'text-green-100',
                'sizeClass' => 'text-xl',
            ],

            $traceCount < 30 => [
                'colorClass' => 'text-green-300',
                'sizeClass' => 'text-3xl',
            ],

            $traceCount < 50 => [
                'colorClass' => 'text-green-500',
                'sizeClass' => 'text-5xl',
            ],

            default => [
                'colorClass' => 'text-geeen-700',
                'sizeClass' => 'text-7xl',
            ],
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
            'dog' => $this->getDogInfo($user),
        ];
    }
}
