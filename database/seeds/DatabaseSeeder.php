<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
/*         $this->call(ResultSeeder::class);
        $this->call(TeamSeeder::class); */
        $this->call(HistoricSeeder::class);
    }
}
