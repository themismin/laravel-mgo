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
        $models = config('laravel-mgo.models');
        $mgoGuards = [
            ['name' => '后台', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '前台', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_guards')->insert($mgoGuards);
    }
}
