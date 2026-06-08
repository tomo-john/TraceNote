<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return view('dashboard', [
            'traceCount' => $user->traces()->count(),
            'tagCount' => $user->tags()->count(),
        ]);
    }
}
