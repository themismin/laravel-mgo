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
            ['name' => 'mgo_column_type', 'display_name' => '定义列属性列类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_column_data_type', 'display_name' => '定义列属性数据类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_index_type', 'display_name' => '定义索引属性索引类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_index_method', 'display_name' => '定义索引属性索引算法', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_foreigns_on_update', 'display_name' => '定义外键属性更新约束', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_foreigns_on_delete', 'display_name' => '定义外键属性删除约束', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_module_type', 'display_name' => '定义模块模块类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_feature_type', 'display_name' => '定义功能功能类型', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],


        ];
        DB::table('mgo_enums')->insert($mgoEnums);
    }
}
