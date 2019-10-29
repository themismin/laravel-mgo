<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoColumnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_columns')->truncate();
        $mgoColumns = [
            ['mgo_table_name' => 'mgo_tables', 'name' => 'id', 'display_name' => '序号', 'type' => 'bigint', 'length' => 20, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => 'ID', 'auto_increment' => 1, 'unsigned' => 1, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'display_name', 'display_name' => '显示名称', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '显示名称', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 1, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'name', 'display_name' => '表名称', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '表名称', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'model_class', 'display_name' => '模型类名', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '模型类名', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'comment', 'display_name' => '备注', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '备注', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'migrate', 'display_name' => '迁移文件', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '迁移文件', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'created_at', 'display_name' => '创建时间', 'type' => 'timestamp', 'length' => null, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '创建时间', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_tables', 'name' => 'updated_at', 'display_name' => '更新时间', 'type' => 'timestamp', 'length' => null, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '更新时间', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // //
            ['mgo_table_name' => 'mgo_columns', 'name' => 'id', 'display_name' => '序号', 'type' => 'bigint', 'length' => 20, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => 'ID', 'auto_increment' => 1, 'unsigned' => 1, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'mgo_table_name', 'display_name' => '定义表属性名称(关联表名称)', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '定义表属性名称(关联表名称)', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'name', 'display_name' => '列名称', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '列名称', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'display_name', 'display_name' => '显示名称', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '显示名称', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 1, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'type', 'display_name' => '列类型', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '列类型', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'length', 'display_name' => '列长度', 'type' => 'int', 'length' => 11, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '列长度', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'decimals', 'display_name' => '小数点长度', 'type' => 'int', 'length' => 11, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '小数点长度', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'not_null', 'display_name' => '是否不为空', 'type' => 'boolean', 'length' => 1, 'decimals' => null, 'not_null' => 1, 'default' => '0', 'comment' => '是否不为空', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'default', 'display_name' => '默认值', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 1, 'default' => '', 'comment' => '默认值', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'comment', 'display_name' => '备注', 'type' => 'varchar', 'length' => 191, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '备注', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'auto_increment', 'display_name' => '是否自增', 'type' => 'boolean', 'length' => 1, 'decimals' => null, 'not_null' => 1, 'default' => '0', 'comment' => '是否自增', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'unsigned', 'display_name' => '是否无符号', 'type' => 'boolean', 'length' => 1, 'decimals' => null, 'not_null' => 1, 'default' => '0', 'comment' => '是否无符号', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'display_key', 'display_name' => '是否展示键', 'type' => 'boolean', 'length' => 1, 'decimals' => null, 'not_null' => 1, 'default' => '0', 'comment' => '是否展示键', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'order_by', 'display_name' => '排序', 'type' => 'bigint', 'length' => 20, 'decimals' => null, 'not_null' => 1, 'default' => '0', 'comment' => '排序', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'created_at', 'display_name' => '创建时间', 'type' => 'timestamp', 'length' => null, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '创建时间', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_table_name' => 'mgo_columns', 'name' => 'updated_at', 'display_name' => '更新时间', 'type' => 'timestamp', 'length' => null, 'decimals' => null, 'not_null' => 0, 'default' => '', 'comment' => '更新时间', 'auto_increment' => 0, 'unsigned' => 0, 'display_key' => 0, 'order_by' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_columns')->insert($mgoColumns);
    }
}