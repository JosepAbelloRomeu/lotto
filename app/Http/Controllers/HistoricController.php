<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Result;
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
        $historics = Historic::take(500)->get()->groupBy('_id');

        $hitsHtml = '<table>';

        foreach ($historics as $historic) {
            $hitsHtml .= '<tr>';
            foreach ($historic as $partido) {
                $prevision = $this->getPrevision($partido->local, $partido->visitor);
                $hitsHtml .= '<td' . ($prevision == $partido->result ? ' style="color: red"' : '') .'>';
                $hitsHtml .= $prevision;
                $hitsHtml .= '</td>';
            }
            $hitsHtml .= '</tr>';
        }

        $hitsHtml .= '</table>';


        return view('hits', ['hitsHtml' => $hitsHtml]);
    }

    public function getPrevision($local, $visitor) {
        $result = Result::where('local', $local)->where('visitor', $visitor)->first();

        $prevision = null;

        if ($result !== null) {
            if ($result->wins > $result->loses) {
                $prevision = '1';
            } else if ($result->wins < $result->loses) {
                $prevision = '2';
            } else {
                $prevision = 'X';
            }
        } else {
            $prevision = 'X';
        }

        return $prevision;
    }


}
