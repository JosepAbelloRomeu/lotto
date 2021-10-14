<?php

namespace App\Http\Controllers;

use App\Http\Services\LottoService;

class LottoController extends Controller
{
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
}
