<?php

namespace App\Http\Controllers;

use App\Team;
use App\Result;
use Illuminate\Http\Request;
use App\Http\Services\ResultService;
use App\Helpers\Helper;

class ResultController extends Controller
{
    protected $resultService;

    public function __construct(ResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    public function index()
    {
        return view('results');
    }

    public function getTeams(Request $request)
    {
        return Team::where('team', 'like', '%' . $request->input('term') . '%')->cursor()->map(function ($team) {
            return ['id' => $team->team, 'text' => $team->team];
        });
    }

    public function handleResult(Request $request)
    {
        $input = $request->input();
        $prevision = [];
        $prevision2 = [];
        $prevision3 = [];

        for ($i = 1; $i <= 15; $i++) {
            if (isset($input['equipo-' . $i . '-1']) && isset($input['equipo-' . $i . '-2'])) {
                $local = $input['equipo-' . $i . '-1'];
                $visitor = $input['equipo-' . $i . '-2'];

                if ($i > 7) {
                    $moreThanSix = true;
                } else {
                    $moreThanSix = false;
                }

                $prevision[$i]['local'] = $local;
                $prevision[$i]['visitor'] = $visitor;
                $prevision[$i]['result1'] = $this->calculatePrevision($local, $visitor, 0, $moreThanSix)[0];
                $prevision[$i]['result2'] = $this->calculatePrevision($local, $visitor, 1, $moreThanSix)[0];
                $prevision[$i]['result3'] = Helper::getBet($local, $visitor, true);
            }
        }

        return view('prevision', ['prevision' => $prevision, 'prevision2' => $prevision2, 'prevision3' => $prevision3]);
    }

    public function calculatePrevision($local, $visitor, $secondBet, $moreThanSix)
    {
        $result = Result::where('local', $local)->where('visitor', $visitor)->first();

        $prevision = null;

        if ($result !== null) {
            if ($result->wins > 2 || $result->loses > 2) {
                $sum = $result->wins + $result->loses + $result->ties;

                $percentageVictories = ($result->wins / $sum) * 100;
                $percentageLoses = ($result->loses / $sum) * 100;
                $percentageTies = ($result->ties / $sum) * 100;

                $arrayPercentages = [
                    'percentageVictories' => $percentageVictories,
                    'percentageLoses' => $percentageLoses,
                    'percentageTies' => $percentageTies
                ];

                arsort($arrayPercentages);

                $counter = 0;
                foreach ($arrayPercentages as $key => $arrayPercentage) {
                    if ($counter == 0 && !$secondBet) {
                        if ($key == 'percentageVictories') {
                            $prevision[] = '1';
                        }
                        if ($key == 'percentageLoses') {
                            $prevision[] = '2';
                        }
                        if ($key == 'percentageTies') {
                            $prevision[] = 'X';
                        }
                    } elseif ($counter == ($moreThanSix ? 1 : 2) && $secondBet) {
                        if ($key == 'percentageVictories') {
                            $prevision[] = '1';
                        }
                        if ($key == 'percentageLoses') {
                            $prevision[] = '2';
                        }
                        if ($key == 'percentageTies') {
                            $prevision[] = 'X';
                        }
                    }


                    $counter++;
                }
            } else {
                $teamOne = Team::where('team', $local)->first();
                $teamTwo = Team::where('team', $visitor)->first();
                if ($teamOne->wins > $teamTwo->wins) {
                    $prevision[] = '1';
                } elseif ($teamOne->wins < $teamTwo->wins) {
                    if ($secondBet && !$moreThanSix) {
                        $prevision[] = 'X';
                    } else {
                        $prevision[] = '2';
                    }
                } else {
                    $prevision[] = 'X';
                }
            }
        } else {
            $prevision[] = 'X';
        }

        return $prevision;
    }
}
