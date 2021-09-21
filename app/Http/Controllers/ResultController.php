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
                if ($result !== null) {
                    if ($result->wins > 3 || $result->loses > 3) {
                        if ($result->wins > $result->loses) {
                            if ($result->wins > $result->ties) {
                                $prevision[] = '1';
                            } else {
                                if ($result->wins > $result->loses + 5) {
                                    $prevision[] = '1';
                                } else {
                                    $prevision[] = 'X';
                                }
                            }
                        } elseif ($result->wins < $result->loses) {
                            if ($result->loses > $result->ties) {
                                $prevision[] = '2';
                            } else {
                                $prevision[] = 'X';
                            }
                        } elseif ($result->wins == $result->loses) {
                            $prevision[] = 'X';
                        } else {
                            $prevision[] = 'X';
                        }
                    } else {
                        $teamOne = Team::where('team', $input['equipo-' . $i . '-1'])->first();
                        $teamTwo = Team::where('team', $input['equipo-' . $i . '-2'])->first();
                        if ($teamOne->wins > $teamTwo->wins) {
                            $prevision[] = '1';
                        } elseif ($teamOne->wins < $teamTwo->wins) {
                            $prevision[] = '2';
                        } else {
                            $prevision[] = 'X';
                        }
                    }
                } else {
                    $prevision[] = 'X';
                }
            }
        }

        return view('prevision', ['prevision' => $prevision]);
    }
}
