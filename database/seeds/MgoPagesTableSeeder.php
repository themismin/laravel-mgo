<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_pages')->truncate();
        $mgoPages = [
            ['mgo_guard_id' => '1', 'name' => '定义表属性管理', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_pages')->insert($mgoPages);
    }
}
