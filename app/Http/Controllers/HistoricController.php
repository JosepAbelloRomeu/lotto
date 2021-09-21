<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
                $prevision = Helper::getPrevision($partido->local, $partido->visitor);

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
}
