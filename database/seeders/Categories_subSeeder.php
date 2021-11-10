<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Categories_subSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories_sub['print'] = ['Makalah', 'Skripsi', 'Laporan Praktikum', 'Jurnal', 'Foto'];
        $categories_sub['fotocopy'] = ['Penjilidan', 'Fotocopy Hitam Putih', 'Fotocopy Berwarna', 'Scanning Document'];
        $id = 1;
        for ($i = 0; $i < sizeof($categories_sub) - 1; $i++){
            if ($categories_sub[$i] == 'print'){
                for ($j = 0; $j < sizeof($categories_sub['print']) - 1; $j++){
                    $data = [
                        'id' => $id,
                        'categories_sub' => 1,
                        'name' => $categories_sub['print'][$j]
                    ];
                    DB::table('categories_sub')->insert($data);
                    $id++;
                }
            } else {
                for ($j = 0; $j < sizeof($categories_sub['fotocopy']) - 1; $j++){
                    $data = [
                        'id' => $id,
                        'categories_sub' => 2,
                        'name' => $categories_sub['fotocopy'][$j]
                    ];
                    DB::table('categories_sub')->insert($data);
                    $id++;
                }
            }
        }
    }
}
