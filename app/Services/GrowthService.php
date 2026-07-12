<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trace;

class GrowthService
{
    public function level(User $user): int
    {
        $traceCount = $user->traces()->count();

        return intdiv($traceCount, 10) + 1;
    }
}
