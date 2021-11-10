<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = ['Printing', 'fotocopy', 'desain'];

        for ($i = 0; $i < sizeof($categories) - 1; $i++){
            $data = [
                'name' => $categories[$i]
            ];
            DB::table('categories')->insert($data);
        }
    }
}
