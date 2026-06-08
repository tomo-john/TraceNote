<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service)
    {
        $user = auth()->user();

        $stats = $service->getStats($user);

        return view('dashboard', $stats);
    }
}
