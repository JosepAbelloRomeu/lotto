<?php

use App\Result;
use App\Team;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
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
            foreach ($jornada as $partido) {
                if (isset($partido->visitante) && isset($partido->resultado) && isset($partido->local) && $partido->local != '(Desconocido)' && $partido->visitante != '(Desconocido)') {
                    $result = Result::where(['local' => $partido->local, 'visitor' => $partido->visitante])->first();
                    $team = Team::where(['team' => $partido->local])->first();
                    $secondTeam = Team::where(['team' => $partido->visitante])->first();

                    switch ($partido->resultado) {
                        case "1":
                            if ($result != null) {
                                $result->increment('wins');
                            }
                            if ($team != null) {
                                $team->increment('wins');
                            }
                        break;
                        case "X":
                            if ($result != null) {
                                $result->increment('ties');
                            }
                        break;
                        case "2":
                            if ($result != null) {
                                $result->increment('loses');
                            }
                            if ($secondTeam != null) {
                                $secondTeam->increment('wins');
                            }
                        break;
                    }
                }
            }
        }
    }

    public function getResults()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/quiniela/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data)->pluck('partidos');
    }
}
