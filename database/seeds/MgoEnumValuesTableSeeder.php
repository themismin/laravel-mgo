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

            ['mgo_enum_name' => 'mgo_column_type', 'name' => 'tinyint', 'display_name' => '小整数', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_type', 'name' => 'bigint', 'display_name' => '极大整数', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_type', 'name' => 'varchar', 'display_name' => '可变字符串', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_type', 'name' => 'text', 'display_name' => '长文本', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_type', 'name' => 'timestamp', 'display_name' => '日期', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'enum', 'display_name' => '枚举', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'number', 'display_name' => '数字', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'text', 'display_name' => '文本', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'rich_text', 'display_name' => '富文本', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'image', 'display_name' => '图片', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'audio', 'display_name' => '音频', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'video', 'display_name' => '视频', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_column_data_type', 'name' => 'belongs_to', 'display_name' => '外键', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_index_type', 'name' => 'PRIMARY', 'display_name' => '主键', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_index_type', 'name' => 'UNIQUE', 'display_name' => '唯一', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_index_method', 'name' => 'BTREE', 'display_name' => 'B树', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_index_method', 'name' => 'HASH', 'display_name' => '哈希', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_foreigns_on_update', 'name' => 'CASCADE', 'display_name' => '自动更新', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_update', 'name' => 'SET NULL', 'display_name' => '设置为空', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_update', 'name' => 'RESTRICT', 'display_name' => '拒绝更新', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_update', 'name' => 'NO ACTION', 'display_name' => '拒绝更新', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_foreigns_on_delete', 'name' => 'CASCADE', 'display_name' => '自动删除', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_delete', 'name' => 'SET NULL', 'display_name' => '设置为空', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_delete', 'name' => 'RESTRICT', 'display_name' => '拒绝删除', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_foreigns_on_delete', 'name' => 'NO ACTION', 'display_name' => '拒绝删除', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_module_type', 'name' => 'index', 'display_name' => '首页', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_module_type', 'name' => 'list', 'display_name' => '列表', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_module_type', 'name' => 'tree', 'display_name' => '树', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_module_type', 'name' => 'charts', 'display_name' => '图表', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_module_type', 'name' => 'view', 'display_name' => '单页', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['mgo_enum_name' => 'mgo_feature_type', 'name' => 'add', 'display_name' => '新增', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_feature_type', 'name' => 'delete', 'display_name' => '删除', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_feature_type', 'name' => 'update', 'display_name' => '修改', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_feature_type', 'name' => 'view', 'display_name' => '详情', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_enum_name' => 'mgo_feature_type', 'name' => 'share', 'display_name' => '分享', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];
        DB::table('mgo_enum_values')->insert($mgoEnumValues);
    }
}
