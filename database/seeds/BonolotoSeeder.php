<?php

use App\Bonoloto;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class BonolotoSeeder extends Seeder
{
    const PER_PAGE = 100000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = $this->getTickets();
        $insertsBonolotos = [];

        foreach ($tickets as $ticket) {
            $bonoloto = $this->createTicket($ticket);
            $insertsBonolotos[] = $bonoloto;
        }

        $teamChunked = array_chunk($insertsBonolotos, 500);
        foreach ($teamChunked as $eachBonoloto) {
            Bonoloto::insert($eachBonoloto);
        }
    }

    public function createTicket($ticket)
    {
        $bonoloto = new Bonoloto();
        $bonoloto->id = hexdec(uniqid());
        $bonoloto->raffle_date = explode('T', $ticket->fecha)[0];
        $bonoloto->raffle = $ticket->sorteo;
        foreach ($ticket->resultado->bolas as $key => $bola) {
            $bonoloto->{"ball_" . $key} = $bola->numero;
        }
        $bonoloto->reinteger = isset($ticket->resultado->reintegro) ? $ticket->resultado->reintegro : null;
        $bonoloto->complementary =  isset($ticket->resultado->complementario) ? $ticket->resultado->complementario : null;

        return $bonoloto->attributesToArray();
    }

    public function getTickets()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/bonoloto/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }
}
