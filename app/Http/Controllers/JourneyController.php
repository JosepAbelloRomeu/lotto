<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Result;
use App\Team;
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
        $matches = Historic::where('_id', $request->id)->get();

        return view('journey', ['matches' => $matches, 'acumulable' => 0]);
    }
}
