<?php

use App\Superonce;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class SuperonceSeeder extends Seeder
{
    const TOTAL_NUMBERS = 20;
    const FIRST_MONTH = 4;
    const FIRST_YEAR = 2010;

    const MONTHS = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->parseHTML();
    }

    public function parseHTML() {
        $years = range(self::FIRST_YEAR, intval(date('Y')));
        $rangeNumbers = range(0, self::TOTAL_NUMBERS-1);

        foreach ($years as $year) {
            $months = self::MONTHS;
            if ($year == self::FIRST_YEAR) {
                $months = array_slice($months, self::FIRST_MONTH, null, true);
            }

            foreach ($months as $key => $month) {
                $keyMonth = $key + 1;
                if (strlen($keyMonth) == 1) {
                    $keyMonth = "0$keyMonth";
                }

                $html = $this->getResults(strtolower($month), $year);

                libxml_use_internal_errors(true);

                $html_doc = new DOMDocument();
                $html_doc->preserveWhiteSpace = false;
                $html_doc->formatOutput = true;
                $html_doc->loadHTML($html);

                $xpath = new DOMXPath($html_doc);
                $s11 = $xpath->query("//div[@class='s11']");
                $superonces = [];

                foreach ($s11 as $eachS11) {
                    $day = $eachS11->getElementsByTagName("span")->item(0)->nodeValue;
                    if (strlen($day) == 1) {
                        $day = "0$day";
                    }
                    $monthAndRaffle = explode('Sorteo', preg_replace(['(\s+)u', '(^\s|\s$)u'], [''], $eachS11->getElementsByTagName("div")->item(0)->childNodes->item(4)->nodeValue));
                    $raffle = $monthAndRaffle[1];

                    $superonce = new Superonce();
                    $superonce->id = hexdec(uniqid());
                    $superonce->raffle_date = "$year-$keyMonth-$day";
                    $superonce->raffle = $raffle;
                    foreach ($rangeNumbers as $rangeNumber) {
                        $number = $eachS11->getElementsByTagName("div")->item(1)->getElementsByTagName("ul")->item(0)->getElementsByTagName("li")->item($rangeNumber)->nodeValue;
                        $superonce->{"number_" . $rangeNumber} = $number;
                    }

                    $superonces[] = $superonce->attributesToArray();
                }

                Superonce::insert($superonces);


            }
        }
    }

    public function getResults($month, $year)
    {
        $client = new Client();
        $res = $client->request('GET', "https://www.juegosonce.es/historico-resultados-superonce-${month}-${year}");

        return $res->getBody()->getContents();
    }
}
