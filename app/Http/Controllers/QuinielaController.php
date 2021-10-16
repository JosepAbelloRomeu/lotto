<?php

namespace App\Http\Controllers;

use App\WorkingDay;
use Illuminate\Http\Request;

class QuinielaController extends Controller
{
    public function index()
    {
        $journey = WorkingDay::take(1)->get();

        $matches = $journey[0]->historics;

        return view('quiniela.home', compact('journey', 'matches'));
    }
}
