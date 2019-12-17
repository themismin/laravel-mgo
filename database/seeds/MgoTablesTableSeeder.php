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
        $models = config('laravel-mgo.models');
        $mgoTables = [
            ['name' => 'mgo_enums', 'display_name' => '定义枚举', 'model_class' => $models['mgo_enums'], 'comment' => '定义枚举', 'migrate' => '2009_09_01_100009_create_mgo_enums_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_enum_values', 'display_name' => '定义枚举值', 'model_class' => $models['mgo_enum_values'], 'comment' => '定义枚举值', 'migrate' => '2009_09_01_100010_create_mgo_enum_values_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_tables', 'display_name' => '定义表属性', 'model_class' => $models['mgo_tables'], 'comment' => '定义表属性', 'migrate' => '2009_10_01_100001_create_mgo_tables_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_columns', 'display_name' => '定义列属性', 'model_class' => $models['mgo_columns'], 'comment' => '定义列属性', 'migrate' => '2009_10_01_100002_create_mgo_columns_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_indices', 'display_name' => '定义索引属性', 'model_class' => $models['mgo_indices'], 'comment' => '定义索引属性', 'migrate' => '2009_10_01_100003_create_mgo_indices_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_foreigns', 'display_name' => '定义外键属性', 'model_class' => $models['mgo_foreigns'], 'comment' => '定义外键属性', 'migrate' => '2009_10_01_100004_create_mgo_foreigns_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_guards', 'display_name' => '定义守卫', 'model_class' => $models['mgo_guards'], 'comment' => '定义守卫', 'migrate' => '2009_10_02_100005_create_mgo_guards_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_pages', 'display_name' => '定义页面', 'model_class' => $models['mgo_pages'], 'comment' => '定义页面', 'migrate' => '2009_10_02_100006_create_mgo_pages_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_modules', 'display_name' => '定义模块', 'model_class' => $models['mgo_modules'], 'comment' => '定义模块', 'migrate' => '2009_10_02_100007_create_mgo_modules_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mgo_features', 'display_name' => '定义功能', 'model_class' => $models['mgo_features'], 'comment' => '定义功能', 'migrate' => '2009_10_02_100008_create_mgo_features_table', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_tables')->insert($mgoTables);
    }
}
