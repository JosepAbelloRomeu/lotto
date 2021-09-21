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
        $historics = Historic::take(450)->get()->groupBy('_id');

        $hitsHtml = '<table>';

        foreach ($historics as $historic) {
            $hitsHtml .= '<tr>';
            $acumulable = 0;
            foreach ($historic as $partido) {
                $prevision = $this->getPrevision($partido->local, $partido->visitor);

                $hitsHtml .= '<td>';
                $hitsHtml .= $prevision;
                $hitsHtml .= '</td>';
            }

            $hitsHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';

            foreach ($historic as $partido) {
                $prevision = $this->getPrevision($partido->local, $partido->visitor);

                $isHit = $prevision == $partido->result;
                if ($isHit) {
                    $acumulable++;
                }

                $hitsHtml .= '<td' . ($prevision == $partido->result ? ' style="color: red;"' : '') .'>';
                $hitsHtml .= $partido->result;
                $hitsHtml .= '</td>';
            }

            $hitsHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
            
            $hitsHtml .= '<td>' . $partido->_id . '</td>';
            $hitsHtml .= '<td' . ($acumulable >= 10 ? ' style="color: red;"' : '') .  '>' . $acumulable . '</td>';
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
