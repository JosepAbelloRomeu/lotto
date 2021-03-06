<?php

namespace App\Helpers;

use App\Team;
use App\Result;
use App\Historic;

class Helper
{
    public static function getPrevision($local, $visitor, $secondBet = 0, $moreThanSix = 0)
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
                    'percentageVictories' => self::getPercentage($local, $visitor, 'win'),
                    'percentageLoses' => self::getPercentage($local, $visitor, 'tie'),
                    'percentageTies' => self::getPercentage($local, $visitor, 'lose')
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
                    } elseif ($counter == ($moreThanSix ? 1 : 2) && $secondBet) {
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
                try {
                    $variable = $teamOne->wins > $teamTwo->wins;
                } catch (\Exception $e) {
                    dump($teamOne, $teamTwo, $local, $visitor);
                }
                if ($teamOne && $teamTwo) {
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
            }
        } else {
            $prevision = 'X';
        }

        return $prevision;
    }

    public static function getBet($local, $visitor, $field = true, $key)
    {
        $wins = Helper::getPercentage($local, $visitor, 'win', $field);
        $ties = Helper::getPercentage($local, $visitor, 'tie', $field);
        $loses = Helper::getPercentage($local, $visitor, 'lose', $field);

        if ($wins > $ties && $wins > $loses) {
            $bet = '1';
        } elseif ($wins > $loses && $wins == $ties) {
            $bet = 'X';
        } elseif ($ties > $wins && $ties > $loses) {
            $bet = 'X';
        } elseif ($ties == $loses) {
            $bet = 'X';
        } elseif ($loses > $wins && $loses > $ties) {
            $bet = '2';
        } else {
            $bet = 'X';
        }

        //TODO Generar un pleno al 15 dependiendo de goles o qu?? s?? yo
        if ($key == 14) {
            switch ($bet) {
                case '1':
                    $bet = '2-1';
                    break;
                case 'X':
                    $bet = '1-1';
                    break;
                case '2':
                    $bet = '1-2';
                    break;
            }
        }

        return $bet;
    }

    public static function fixedBet($index)
    {
        $fixedBet = ['1', '2', '2', '1', 'X', '2', 'X', '1', '2', '2', '1', '2', '1', 'X', '2-1'];

        return $fixedBet[$index];
    }

    public static function getPercentage($local, $visitor, $type = 'win', $field = true)
    {
        if ($field) {
            $historics = Historic::where('local', $local)->where('visitor', $visitor)->get();
        } else {
            $historics = Historic::where('local', $local)->where('visitor', $visitor)
                                    ->orWhere(function ($query) use ($local, $visitor) {
                                        $query->where('local', $visitor)->where('visitor', $local);
                                    })
            ->get();
        }
        
        $wins = $historics->where('result', '=', '1');
        $ties = $historics->where('result', '=', 'X');
        $loses = $historics->where('result', '=', '2');

        $total = $historics->count();

        switch ($type) {
            case 'win':
                $percentage = floor(($wins->count() / $total) * 100);
                break;
            case 'tie':
                $percentage = floor(($ties->count() / $total) * 100);
                break;
            case 'lose':
                $percentage = floor(($loses->count() / $total) * 100);
                break;
        }

        return $percentage;
    }
}
