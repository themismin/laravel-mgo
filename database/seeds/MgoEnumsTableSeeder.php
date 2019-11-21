<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoEnumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_enums')->truncate();
        $mgoEnums = [
            ['name' => 'mgo_column_data_type', 'display_name' => '定义列属性数据类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_enums')->insert($mgoEnums);
    }
}
