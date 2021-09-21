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

            $hitsHtml .= '<td>' . $historic[0]->league_date->format('d/m/Y') . '</td>';
            $hitsHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';

            foreach ($historic as $partido) {
                $prevision = $this->getPrevision($partido->local, $partido->visitor);

                $isHit = $prevision == $partido->result;
                if ($isHit) {
                    $acumulable++;
                }

                $hitsHtml .= '<td class="number ' . ($prevision == $partido->result ? 'hit' : '').'">';
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

    public function getPrevision($local, $visitor)
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
}
