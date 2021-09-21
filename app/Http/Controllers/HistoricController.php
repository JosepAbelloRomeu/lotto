<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Result;
use App\Team;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historics = Historic::take(3014)->get()->groupBy('_id');

        $hitsHtml = '<table>';

        foreach ($historics as $historic) {
            $hitsHtml .= '<tr>';
            foreach ($historic as $partido) {
                $prevision = $this->getPrevision($partido->local, $partido->visitor);
                $hitsHtml .= '<td' . ($prevision == $partido->result ? ' style="color: red;"' : '') .'>';
                $hitsHtml .= $prevision;
                $hitsHtml .= '</td>';
            }
            $hitsHtml .= '<td>' . $partido->_id . '</td>';
            $hitsHtml .= '</tr>';
        }

        $hitsHtml .= '</table>';


        return view('hits', ['hitsHtml' => $hitsHtml]);
    }

    public function getPrevision($local, $visitor) {
        $result = Result::where('local', $local)->where('visitor', $visitor)->first();

        $prevision = null;

        if ($result !== null) {
            if ($result->wins > 5 || $result->loses > 5) {
                if ($result->wins > $result->loses) {
                    $prevision = '1';
                } else if ($result->wins < $result->loses) {
                    $prevision = '2';
                } else {
                    $prevision = 'X';
                }
            } else {
                $teamOne = Team::where('team', $local)->first();
                $teamTwo = Team::where('team', $visitor)->first();
                if ($teamOne->wins > $teamTwo->wins) {
                    $prevision = '1';
                } else if ($teamOne->wins < $teamTwo->wins) {
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
