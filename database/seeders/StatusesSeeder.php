<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = ['process', 'deliver', 'cancel', 'pending'];

        for ($i = 0; $i < sizeof($statuses)-1; $i++){
            $data = [
                'name' => $statuses[$i]
            ];
            DB::table('statuses')->insert($data);
        }
    }
}
