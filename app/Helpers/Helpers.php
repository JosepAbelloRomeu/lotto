<?php

use App\Team;
use App\Result;

function getPrevision($local, $visitor)
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
