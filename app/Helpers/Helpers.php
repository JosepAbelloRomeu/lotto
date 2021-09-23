<?php

namespace App\Helpers;

use App\Team;
use App\Result;

class Helper{
    public static function getPrevision($local, $visitor, $secondBet, $moreThanSix)
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
                            $prevision = '1';
                        }
                        if ($key == 'percentageLoses') {
                            $prevision = '2';
                        }
                        if ($key == 'percentageTies') {
                            $prevision = 'X';
                        }
                    } else if ($counter == ($moreThanSix ? 1 : 2) && $secondBet) {
                        if ($key == 'percentageVictories') {
                            $prevision = '1';
                        }
                        if ($key == 'percentageLoses') {
                            $prevision = '2';
                        }
                        if ($key == 'percentageTies') {
                            $prevision = 'X';
                        }
                    }


                    $counter++;
                }



                /* if ($result->wins > $result->loses) {
                    if ($result->wins > $result->ties) {
                        $prevision = '1';
                    } else {
                        if ($result->wins > $result->loses + 5) {
                            $prevision = '1';
                        } else {
                            $prevision = 'X';
                        }
                    }
                } elseif ($result->wins < $result->loses) {
                    if ($result->loses > $result->ties) {
                        $prevision = '2';
                    } else {
                        $prevision = 'X';
                    }
                } elseif ($result->wins == $result->loses) {
                    $prevision = 'X';
                } else {
                    $prevision = 'X';
                } */
            } else {
                $teamOne = Team::where('team', $local)->first();
                $teamTwo = Team::where('team', $visitor)->first();
                if ($teamOne->wins > $teamTwo->wins) {
                    $prevision = '1';
                } elseif ($teamOne->wins < $teamTwo->wins) {
                    if ($secondBet && !$moreThanSix) {
                        $prevision = 'X';
                    } else {
                        $prevision = '2';
                    }
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
