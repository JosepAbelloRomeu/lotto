<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Historic;
use App\Result;
use App\Team;
use App\WorkingDay;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workingDays = WorkingDay::take(20)->cursor();

        return view('hits', compact('workingDays'));
    }
}
