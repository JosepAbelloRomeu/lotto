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

    public function getPrevision($local, $visitor)
    {
        $result = Result::where('local', $local)->where('visitor', $visitor)->first();

        $prevision = null;

        if ($result !== null) {
            if ($result->wins > 5 || $result->loses > 5) {
                if ($result->wins > $result->loses) {
                    $prevision = '1';
                } elseif ($result->wins < $result->loses) {
                    $prevision = '2';
                } else {
                    $prevision = 'X';
                }
            } else {
                $teamOne = Team::where('team', $local)->first();
                $teamTwo = Team::where('team', $visitor)->first();
                if ($teamOne->wins > $teamTwo->wins) {
                    $prevision = '1';
                } elseif ($teamOne->wins < $teamTwo->wins) {
                    $prevision = '2';
                } else {
                    $prevision = 'X';
                }
            }
        } else {
            $prevision = 'X';
        }

        return $prevision;
    }
}
