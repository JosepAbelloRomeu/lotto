<?php

use App\Bonoloto;
use App\Primitiva;
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
        $primis = $this->getPrimis();
        $insertsBonolotos = [];
        $insertsPrimitivas = [];

        foreach ($tickets as $ticket) {
            $bonoloto = $this->createTicket($ticket);
            $insertsBonolotos[] = $bonoloto;
        }

        foreach ($primis as $primi) {
            $primitiva = $this->createPrimi($primi);
            $insertsPrimitivas[] = $primitiva;
        }

        $teamChunked = array_chunk($insertsBonolotos, 500);
        foreach ($teamChunked as $eachBonoloto) {
            Bonoloto::insert($eachBonoloto);
        }

        $teamChunked = array_chunk($insertsPrimitivas, 500);
        foreach ($teamChunked as $eachPrimitiva) {
            Primitiva::insert($eachPrimitiva);
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

    public function createPrimi($primi)
    {
        $primitiva = new Primitiva();
        $primitiva->id = hexdec(uniqid());
        $primitiva->raffle_date = explode('T', $primi->fecha)[0];
        $primitiva->raffle = $primi->sorteo;
        foreach ($primi->resultado->bolas as $key => $bola) {
            $primitiva->{"ball_" . $key} = $bola->numero;
        }
        $primitiva->reinteger = isset($primi->resultado->reintegro) ? $primi->resultado->reintegro : null;
        $primitiva->complementary =  isset($primi->resultado->complementario) ? $primi->resultado->complementario : null;

        return $primitiva->attributesToArray();
    }

    public function getTickets()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/bonoloto/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }

    public function getPrimis()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.pronostigol.es/api/primitiva/tickets?per_page=' . self::PER_PAGE);

        return collect(json_decode($res->getBody())->data);
    }
}
