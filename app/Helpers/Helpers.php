<?php

use App\Team;
use App\Result;

function getPrevision($local, $visitor)
{
    $result = Result::where('local', $local)->where('visitor', $visitor)->first();

    $prevision = null;

    if ($result !== null) {
        if ($result->wins > 3 || $result->loses > 3) {
            if ($result->wins > $result->loses) {
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
