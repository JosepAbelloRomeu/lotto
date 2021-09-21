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
                if (isset($partido->visitante) && isset($partido->resultado) && isset($partido->local)) {
                    $result = Result::firstOrNew(['local' => $partido->local, 'visitor' => $partido->visitante]);
                    $team = Team::firstOrNew(['team' => $partido->local]);
                    $secondTeam = Team::firstOrNew(['team' => $partido->visitante]);
                    $result->save();
                    $team->save();
                    $secondTeam->save();
                    switch ($partido->resultado) {
                        case "1":
                            $result->increment('wins');
                            $team->increment('wins');
                        break;
                        case "X":
                            $result->increment('ties');
                        break;
                        case "2":
                            $result->increment('loses');
                            $secondTeam->increment('wins');
                        break;
                    }
                }
            }
        }
    }

    public function getResults() {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/quiniela/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data)->pluck('partidos');
    }
}
