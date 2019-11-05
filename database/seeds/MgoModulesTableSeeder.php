<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_modules')->truncate();
        $mgoModules = [
            ['name' => '定义表属性管理', 'mgo_table_name' => 'mgo_tables', 'default_type' => 'list', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_modules')->insert($mgoModules);
    }
}
