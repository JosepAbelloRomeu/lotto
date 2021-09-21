<?php

namespace App\Http\Controllers;

use App\Http\Services\LottoService;

class LottoController extends Controller
{
    protected $lottoService;

    public function __construct(LottoService $lottoService) {
        $this->lottoService = $lottoService;
    }

    public function index() {

        $results = $this->lottoService->getResults();
        $coloredNumbers = $this->lottoService->getColoredNumbersWithAllNumbers($results);

        return view('lotto', ['results' => $coloredNumbers['results'], 'numbers' => $this->lottoService::NUMBERS, 'counted' => $coloredNumbers['counted']]);
    }

    public function random() {

        $results = $this->lottoService->getResults();
        $coloredNumbers = $this->lottoService->getColoredNumbersWithRandomizedNumbers($results);

        return view('lotto', ['results' => $coloredNumbers['results'], 'numbers' => $this->lottoService::NUMBERS, 'counted' => $coloredNumbers['counted']]);
    }
}
