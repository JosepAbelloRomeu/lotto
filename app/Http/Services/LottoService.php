<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class LottoService {

    const NUMBERS = [2,3,5,6,7,9,11,12,13,15,17,18,19,21,23,24,27,29,30,31,33,36,37,39,41,42,45,47,48];

    public function getResults() {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/bonoloto/tickets?page=1&per_page=100000');

        return collect(json_decode($res->getBody())->data)->pluck('resultado.bolas');
    }

    public function getColoredNumbersWithAllNumbers($results) {
        $collection = collect();

        foreach ($results as $result) {

            $hits = 0;
            $collectionNumbers = collect();
            foreach ($result as $number) {
                if (in_array($number->numero, self::NUMBERS)) {

                    $red = 'red';
                    $hits++;
                } else {
                    $red = null;
                }

                $collectNumbers = $collectionNumbers->push([
                    'color' => $red,
                    'number' => $number->numero,

                ]);
            }

            $collection->push([
                'numbers' => $collectNumbers,
                'hits' => $hits
            ]);
        }

        $results = collect($collection->sortByDesc('hits')->values()->all());

        $counted = $results->countBy('hits');

        return ['results' => $results, 'counted' => $counted];
    }

    public function getColoredNumbersWithRandomizedNumbers($results) {
        $collection = collect();

        foreach ($results as $result) {

            $hits = 0;
            $collectionNumbers = collect();
            $shuffledNumbers = self::NUMBERS;
            shuffle($shuffledNumbers);

            $sixSuffledNumbers = array_slice($shuffledNumbers, 0, 6);

            foreach ($result as $number) {
                if (in_array($number->numero, $sixSuffledNumbers)) {

                    $blue = 'blue';
                    $hits++;
                } else {
                    $blue = null;
                }

                $collectNumbers = $collectionNumbers->push([
                    'color' => $blue,
                    'number' => $number->numero,

                ]);
            }

            $collection->push([
                'numbers' => $collectNumbers,
                'shuffledNumbers' => collect($sixSuffledNumbers)->sort()->values()->all(),
                'hits' => $hits
            ]);
        }

        $results = collect($collection->sortByDesc('hits')->values()->all());

        $counted = $results->countBy('hits');

        return ['results' => $results, 'counted' => $counted];
    }
}
