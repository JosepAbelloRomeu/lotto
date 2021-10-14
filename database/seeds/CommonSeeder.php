<?php

use App\Team;
use App\Result;
use App\Historic;
use App\WorkingDay;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    const PER_PAGE = 100000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO Comprobar si registros en BD
        $jornadas = $this->getResults();
        $insertsWorkingDays = [];
        $insertsHistorics = [];
        $insertsResults = [];
        $insertsTeams = [];

        $existentTeams = [];
        $existentResults = [];

        foreach ($jornadas as $jornada) {
            $workingDay = $this->workingDays($jornada);
            $workingDayId = $workingDay['id'];
            $insertsWorkingDays[] = $workingDay;

            foreach ($jornada->partidos as $partido) {
                if (isset($partido->visitante) && isset($partido->resultado) && isset($partido->local) && $partido->local != '(Desconocido)' && $partido->visitante != '(Desconocido)') {
                    $historic = $this->historic($partido, $workingDayId);
                    $insertsHistorics[] = $historic;

                    // Comprobar Results
                    $registerExist = array_search(["local" => $partido->local, "visitor" => $partido->visitante], $existentResults);

                    if (!$registerExist) {
                        $existentResults[] = ['local' => $partido->local, 'visitor' => $partido->visitante];
                        $result = $this->results($partido);
                        $insertsResults[] = $result;
                    }

                    // End Comprobar Results

                    // Comprobar Teams
                    $teamName = '';

                    $registerExistLocal = array_search(["team" => $partido->local], $existentTeams);
                    $registerExistVisitor = array_search(["team" => $partido->visitante], $existentTeams);

                    if (!$registerExistLocal || !$registerExistVisitor) {
                        if (!$registerExistLocal) {
                            $teamName = $partido->local;
                        }
                        if (!$registerExistVisitor) {
                            $teamName = $partido->visitante;
                        }
                    }

                    if (!$registerExistLocal || !$registerExistVisitor) {
                        $team = $this->teams($teamName);
                        $insertsTeams[] = $team;
                        $existentTeams[] = ['team' => $teamName];
                    }

                    // END Comprobar Teams
                }
            }
        }

        WorkingDay::insert($insertsWorkingDays);

        $historicChunked = array_chunk($insertsHistorics, 500);
        foreach ($historicChunked as $eachHistoric) {
            Historic::insert($eachHistoric);
        }

        $resultChunked = array_chunk($insertsResults, 500);
        foreach ($resultChunked as $eachResult) {
            Result::insert($eachResult);
        }

        $teamChunked = array_chunk($insertsTeams, 500);
        foreach ($teamChunked as $eachTeam) {
            Team::insert($eachTeam);
        }
    }

    public function historic($partido, $workingDayId)
    {
        $historic = new Historic();
        $historic->id = hexdec(uniqid());
        $historic->working_day_id = $workingDayId;
        $historic->local = $partido->local;
        $historic->visitor = $partido->visitante;
        $historic->result = $partido->resultado;
        $historic->resultWithGoals = isset($partido->resultadoConGoles) ? $partido->resultadoConGoles : null;

        return $historic->attributesToArray();
    }

    public function results($partido)
    {
        $result = new Result();
        $result->id = hexdec(uniqid());
        $result->local = $partido->local;
        $result->visitor = $partido->visitante;
        $result->localGoals = isset($partido->golesLocal) ? $partido->golesLocal : 0;
        $result->visitorGoals = isset($partido->golesVisitante) ? $partido->golesVisitante : 0;

        return $result->attributesToArray();
    }

    public function workingDays($jornada)
    {
        $workingDay = new WorkingDay();
        $workingDay->id = hexdec(uniqid());
        $workingDay->_id = $jornada->_id;
        $workingDay->league_date = explode('T', $jornada->fecha)[0];
        $workingDay->season = $jornada->temporada;
        $workingDay->modality = $jornada->modalidad;
        $workingDay->working_day = $jornada->jornada;

        return $workingDay->attributesToArray();
    }

    public function teams($teamName)
    {
        $team = new Team();
        $team->id = hexdec(uniqid());
        $team->team = $teamName;

        return $team->attributesToArray();
    }

    public function getResults()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/quiniela/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }
}
