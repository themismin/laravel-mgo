<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoGuardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_guards')->truncate();
        $mgoGuards = [
            ['display_name' => '后台', 'name' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['display_name' => '前台', 'name' => 'web', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        DB::table('mgo_guards')->insert($mgoGuards);
    }
}
