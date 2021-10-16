<?php

namespace App\Http\Controllers;

use App\Bonoloto;
use App\WorkingDay;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $journey = WorkingDay::take(1)->get();
        $matches = $journey[0]->historics;

        $bonoloto = Bonoloto::take(1)->get();

        return view('home', compact('journey', 'matches', 'bonoloto'));
    }
}
