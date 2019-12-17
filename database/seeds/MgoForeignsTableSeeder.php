<?php
/**
 * Created by PhpStorm.
 * User: xlb
 * Date: 2019/12/6
 * Time: 11:02
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MgoForeignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_foreigns')->truncate();
        $mgoEnums = [
            ['mgo_table_name' => 'mgo_enum_values', 'name' => 'mgo_enum_name', 'mgo_column_id' => '201', 'referenced_mgo_table_name' => 'mgo_enums', 'referenced_mgo_column_id' => '101', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'mgo_table_name', 'mgo_column_id' => '401', 'referenced_mgo_table_name' => 'mgo_tables', 'referenced_mgo_column_id' => '301', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'mgo_enum_name', 'mgo_column_id' => '413', 'referenced_mgo_table_name' => 'mgo_enums', 'referenced_mgo_column_id' => '101', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_indices', 'name' => 'mgo_table_name', 'mgo_column_id' => '501', 'referenced_mgo_table_name' => 'mgo_tables', 'referenced_mgo_column_id' => '301', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_modules', 'name' => 'mgo_page_id', 'mgo_column_id' => '901', 'referenced_mgo_table_name' => 'mgo_pages', 'referenced_mgo_column_id' => '800', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_modules', 'name' => 'mgo_table_name', 'mgo_column_id' => '903', 'referenced_mgo_table_name' => 'mgo_tables', 'referenced_mgo_column_id' => '301', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_features', 'name' => 'mgo_module_id', 'mgo_column_id' => '1001', 'referenced_mgo_table_name' => 'mgo_modules', 'referenced_mgo_column_id' => '900', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_pages', 'name' => 'mgo_guard_id', 'mgo_column_id' => '801', 'referenced_mgo_table_name' => 'mgo_guards', 'referenced_mgo_column_id' => '700', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_foreigns', 'name' => 'mgo_table_name', 'mgo_column_id' => '601', 'referenced_mgo_table_name' => 'mgo_tables', 'referenced_mgo_column_id' => '301', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_foreigns', 'name' => 'mgo_column_id', 'mgo_column_id' => '603', 'referenced_mgo_table_name' => 'mgo_columns', 'referenced_mgo_column_id' => '400', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_foreigns', 'name' => 'referenced_mgo_table_name', 'mgo_column_id' => '604', 'referenced_mgo_table_name' => 'mgo_tables', 'referenced_mgo_column_id' => '301', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_foreigns', 'name' => 'referenced_mgo_column_id', 'mgo_column_id' => '605', 'referenced_mgo_table_name' => 'mgo_columns', 'referenced_mgo_column_id' => '400', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];
        DB::table('mgo_foreigns')->insert($mgoEnums);
    }

}