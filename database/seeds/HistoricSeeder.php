<?php

use App\Historic;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class HistoricSeeder extends Seeder
{
    const PER_PAGE = 100000;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jornadas = $this->getResults();

        foreach ($jornadas as $jornada) {
            foreach ($jornada->partidos as $partido) {
                if (isset($partido->visitante) && isset($partido->resultado) && isset($partido->local)) {
                    $historic = Historic::firstOrNew(['_id' => $jornada->_id,'local' => $partido->local, 'visitor' => $partido->visitante]);
                    $historic->result = $partido->resultado;
                    $historic->save();
                }
            }
        }
    }

    public function getResults() {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/quiniela/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }
}
