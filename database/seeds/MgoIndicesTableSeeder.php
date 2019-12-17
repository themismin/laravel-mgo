<?php
/**
 * Created by PhpStorm.
 * User: xlb
 * Date: 2019/12/4
 * Time: 14:56
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MgoIndicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_indices')->truncate();
        $mgoEnums = [
            ['mgo_table_name' => 'mgo_enums', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_enum_values', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_indices', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_foreigns', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_guards', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_pages', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_modules', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_features', 'name' => 'id', 'fields' => 'id', 'type' => 'PRIMARY', 'method' => 'BTREE', 'comment' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_indices')->insert($mgoEnums);
    }
}