<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoEnumValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_enum_values')->truncate();
        $mgoEnumValues = [
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'enum', 'display_name' => '枚举', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'number', 'display_name' => '数字', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'text', 'display_name' => '文本', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'rich_text', 'display_name' => '富文本', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_enum_values')->insert($mgoEnumValues);
    }
}
