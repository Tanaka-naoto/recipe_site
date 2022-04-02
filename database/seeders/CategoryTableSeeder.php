<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate(); //2回目実行の際にシーダー情報をクリア
        DB::table('categories')->insert([
            'name' => '和食',
        ]);
        DB::table('categories')->insert([
            'name' => '洋食',
        ]);
        DB::table('categories')->insert([
            'name' => 'フレンチ',
        ]);
        DB::table('categories')->insert([
            'name' => 'サラダ',
        ]);
        DB::table('categories')->insert([
            'name' => 'スイーツ',
        ]);
    }
}
