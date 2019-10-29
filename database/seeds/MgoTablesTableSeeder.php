<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoTablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_tables')->truncate();
        $mgoTables = [
            ['display_name' => '定义表属性', 'name' => 'mgo_tables', 'model_class' => 'ThemisMin\LaravelMgo\Models\MgoTable', 'comment' => '定义表属性', 'migrate' => '2009_10_01_100001_create_mgo_tables_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['display_name' => '定义列属性', 'name' => 'mgo_columns', 'model_class' => 'ThemisMin\LaravelMgo\Models\MgoColumn', 'comment' => '定义列属性', 'migrate' => '2009_10_01_100002_create_mgo_columns_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_tables')->insert($mgoTables);
    }
}
