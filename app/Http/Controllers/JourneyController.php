<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Result;
use App\Team;
use App\WorkingDay;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $matches = WorkingDay::where('_id', $request->id)->first();

        return view('journey', ['matches' => $matches, 'acumulable' => 0]);
    }
}
