<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $service = new DashboardService();

        $stats = $service->getStats($user);

        return view('dashboard', $stats);
    }
}
