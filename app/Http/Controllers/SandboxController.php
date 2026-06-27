<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraceRelation;

class SandboxController extends Controller
{
    public function __invoke()
    {
        $relations = TraceRelation::all();
        // dd($relations);
        return view('sandbox', compact('relations'));
    }
}
