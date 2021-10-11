<?php

use App\Historic;
use App\WorkingDay;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WorkingDay::truncate();
        Historic::truncate();

        $jornadas = $this->getResults();

        foreach ($jornadas as $jornada) {
            $workingDay = WorkingDay::create(['_id' => $jornada->_id, 'league_date' => $jornada->fecha, 'season' => $jornada->temporada, 'working_day' => $jornada->jornada]);
            foreach ($jornada->partidos as $partido) {
                if (isset($partido->visitante) && isset($partido->resultado) && isset($partido->local)) {
                    $resultWithGoals = isset($partido->resultadoConGoles) ? $partido->resultadoConGoles : null;
                    Historic::create(['working_day_id' => $workingDay->id, 'local' => $partido->local, 'visitor' => $partido->visitante, 'result' => $partido->resultado, 'resultWithGoals' => $resultWithGoals]);
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function getResults()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/quiniela/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }
}
