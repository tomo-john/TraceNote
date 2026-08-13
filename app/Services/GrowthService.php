<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;

class GrowthService
{
    private function getTraceCount(User $user): int
    {
        return $user->traces()->count();
    }

    public function getLevelInfo(User $user): array
    {
        $traceCount = $this->getTraceCount($user);

        $level = 0;
        $requiredTraces = 1;
        $remainingTraces = $traceCount;
        $requiredLevelUps = 1;

        while ($remainingTraces >= $requiredTraces) {
            $remainingTraces -= $requiredTraces;
            $level++;

            $requiredLevelUps--;

            if ($requiredLevelUps === 0) {
                $requiredTraces++;
                $requiredLevelUps = $requiredTraces;
            }
        }

        $remainingToNextLevel = $requiredTraces - $remainingTraces;
        $progress = ($remainingTraces / $requiredTraces) * 100;

        return [
            'level' => $level,
            'traceCount' => $traceCount,
            'remainingTraces' => $remainingToNextLevel,
            'progress' => $progress,
        ];
    }

    public function getDogInfo(User $user): array
    {
        $traceCount = $this->getTraceCount($user);

        return match (true) {
            $traceCount < 1 => [
                'colorClass' => 'text-green-100',
                'sizeClass' => 'text-xl',
            ],

            $traceCount < 10 => [
                'colorClass' => 'text-green-200',
                'sizeClass' => 'text-3xl',
            ],

            $traceCount < 30 => [
                'colorClass' => 'text-green-300',
                'sizeClass' => 'text-5xl',
            ],

            $traceCount < 50 => [
                'colorClass' => 'text-green-500',
                'sizeClass' => 'text-7xl',
            ],

            default => [
                'colorClass' => 'text-green-700',
                'sizeClass' => 'text-9xl',
            ],
        };
    }
}
