<?php

namespace App\Http\Controllers;

use App\Http\Services\ResultService;
use App\Result;
use App\Team;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected $resultService;

    public function __construct(ResultService $resultService) {
        $this->resultService = $resultService;
    }

    public function index() {

        return view('results');
    }

    public function getTeams(Request $request) {
        return Team::where('team', 'like', '%' . $request->input('term') . '%')->cursor()->map(function($team) {
            return ['id' => $team->team, 'text' => $team->team];
        });
    }

    public function handleResult(Request $request) {
        $input = $request->input();
        $prevision = [];

        for ($i = 1; $i <= 15; $i++) {
            if (isset($input['equipo-' . $i . '-1']) && isset($input['equipo-' . $i . '-2'])) {
                $result = Result::where('local', $input['equipo-' . $i . '-1'])->where('visitor', $input['equipo-' . $i . '-2'])->first();
                /**
                 * Comprovar si result es null i fer el contrari
                 *
                 * comprovar que no té 1 o 2 wins i mirar el total de wins de cada equip
                 *
                 */
                if ($result !== null) {
                    if ($result->wins > $result->loses) {
                        $prevision[] = '1';
                    } else if ($result->wins <= $result->loses) {
                        $prevision[] = '2';
                    }
                } else {
                    $prevision[] = 'X';
                }
            }
        }

        return view('prevision', ['prevision' => $prevision]);
    }
}
