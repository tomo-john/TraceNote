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

    public function getGrowthInfo(User $user): array
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
        $progress = round(($remainingTraces / $requiredTraces) * 100);

        return [
            'level' => $level,
            'remainingTraces' => $remainingToNextLevel,
            'progress' => $progress,
            'dog' => $this->getDogInfo($level),
        ];
    }

    private function getDogInfo(int $level): array
    {
        return match (true) {
            $level <= 2 => [
                'stage' => 'Baby',
                'colorClass' => 'text-green-100',
                'sizeClass' => 'text-xl',
            ],

            $level <= 5 => [
                'stage' => 'Puppy',
                'colorClass' => 'text-green-200',
                'sizeClass' => 'text-3xl',
            ],

            $level <= 9 => [
                'stage' => 'Young',
                'colorClass' => 'text-green-300',
                'sizeClass' => 'text-5xl',
            ],

            $level <= 14 => [
                'stage' => 'Adult',
                'colorClass' => 'text-green-500',
                'sizeClass' => 'text-7xl',
            ],

            default => [
                'stage' => 'Master',
                'colorClass' => 'text-green-700',
                'sizeClass' => 'text-9xl',
            ],
        };
    }
}
