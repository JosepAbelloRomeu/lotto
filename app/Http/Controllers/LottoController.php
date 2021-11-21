<?php

namespace App\Http\Controllers;

use App\Http\Services\LottoService;
use App\Superonce;

class LottoController extends Controller
{
    const TOTAL_NUMBERS = 20;

    protected $lottoService;

    public function __construct(LottoService $lottoService)
    {
        $this->lottoService = $lottoService;
    }

    public function index()
    {
        $results = $this->lottoService->getResults();
        $coloredNumbers = $this->lottoService->getColoredNumbersWithAllNumbers($results);

        return view('lotto', ['results' => $coloredNumbers['results'], 'numbers' => $this->lottoService::NUMBERS, 'counted' => $coloredNumbers['counted']]);
    }

    public function random()
    {
        $results = $this->lottoService->getResults();
        $coloredNumbers = $this->lottoService->getColoredNumbersWithRandomizedNumbers($results);
        return view('lotto', ['results' => $coloredNumbers['results'], 'numbers' => $this->lottoService::NUMBERS, 'counted' => $coloredNumbers['counted']]);
    }

    public function superonce()
    {
        $selectedNumbers = 5;
        $numberOfGeneratedCombinations = range(1, 100);
        $eightyNumbers = range(1, 80);
        shuffle($eightyNumbers);
        $combination = array_slice($eightyNumbers, 0, $selectedNumbers);
        sort($combination);

        $collection = collect();

        foreach ($numberOfGeneratedCombinations as $numberOfGeneratedCombination) {
            shuffle($eightyNumbers);
            $hits = 0;
            $resultNumbers = array_slice($eightyNumbers, 0, 20);
            foreach ($combination as $eachCombination) {
                if (in_array($eachCombination, $resultNumbers)) {
                    $hits++;
                }
            }

            $collection->push(['hits' => $hits]);
        }

        $results = collect($collection->sortByDesc('hits')->values()->all());
        $counted = $results->countBy('hits');


        return view('superonce', ['combination' => $combination, 'counted' => $counted]);
    }

    public function superonceStatistics()
    {
        $superonces = Superonce::cursor();
        $rangeNumbers = range(0, self::TOTAL_NUMBERS - 1);
        $moreThanThreeRow = 0;
        $moreThanTenDiferenceRow = 0;

        foreach ($superonces as $superonce) {
            $arraySuperOnces = [];
            foreach ($rangeNumbers as $rangeNumber) {
                $arraySuperOnces[] = $superonce->{"number_" . $rangeNumber};
            }

            $threeConsecutives = $this->checkMoreThanThreeConsecutive($arraySuperOnces);
            if ($threeConsecutives > 0) {
                $moreThanThreeRow ++;//+= $threeConsecutives;
            }

            $moreThan10difference = $this->checkMoreThanTenConsecutive($arraySuperOnces);
            if ($moreThan10difference > 0) {
                $moreThanTenDiferenceRow ++;//+= $moreThan10difference;
            }
        }

        return view('superonce-statistics', ['moreThanThreeRow' => $moreThanThreeRow, 'superonces' => $superonces, 'moreThanTenDiferenceRow' => $moreThanTenDiferenceRow]);
    }

    function checkMoreThanThreeConsecutive($array)
    {
        $ret  = array();
        $temp = array();
        $consecutiveNumbers = 0;
        foreach ($array as $val) {
            if (next($array) == ($val + 1)) {
                $temp[] = $val;
            } else {
                if (count($temp) > 0) {
                    $temp[] = $val;
                    $ret[] = $temp[0] . ':' . end($temp);
                    if (intval(end($temp)) - intval($temp[0]) > 3) {
                        $consecutiveNumbers++;
                    }
                    $temp = array();
                } else {
                    $ret[] = $val;
                }
            }
        }

        return $consecutiveNumbers;
    }

    function checkMoreThanTenConsecutive($array)
    {
        $moreTenDifference = 0;
        foreach ($array as $val) {
            if (next($array) > ($val + 19)) {
                $moreTenDifference++;
            }
        }

        return $moreTenDifference;
    }
}
