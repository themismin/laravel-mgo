<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_features')->truncate();
        $mgoFeatures = [
            ['id' => 100,'mgo_module_id' => '1', 'name' => '新增', 'type' => 'create', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 101,'mgo_module_id' => '1', 'name' => '删除', 'type' => 'destroy', 'attr' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 102,'mgo_module_id' => '1', 'name' => '修改', 'type' => 'edit', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 103,'mgo_module_id' => '1', 'name' => '详情', 'type' => 'show', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['id' => 200,'mgo_module_id' => '2', 'name' => '新增', 'type' => 'create', 'attr' => '{"columns":[{"column":"mgo_table_name"},{"column":"name"},{"column":"display_name"},{"column":"type"},{"column":"length"},{"column":"decimals"},{"column":"not_null"},{"column":"default"},{"column":"comment"},{"column":"auto_increment"},{"column":"unsigned"},{"column":"data_type"},{"column":"mgo_enum_name"},{"column":"display_key"},{"column":"order_by"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 201,'mgo_module_id' => '2', 'name' => '删除', 'type' => 'destroy', 'attr' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 202,'mgo_module_id' => '2', 'name' => '修改', 'type' => 'edit', 'attr' => '{"columns":[{"column":"mgo_table_name"},{"column":"name"},{"column":"display_name"},{"column":"type"},{"column":"length"},{"column":"decimals"},{"column":"not_null"},{"column":"default"},{"column":"comment"},{"column":"auto_increment"},{"column":"unsigned"},{"column":"data_type"},{"column":"mgo_enum_name"},{"column":"display_key"},{"column":"order_by"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 203,'mgo_module_id' => '2', 'name' => '详情', 'type' => 'show', 'attr' => '{"columns":[{"column":"mgo_table_name"},{"column":"name"},{"column":"display_name"},{"column":"type"},{"column":"length"},{"column":"decimals"},{"column":"not_null"},{"column":"default"},{"column":"comment"},{"column":"auto_increment"},{"column":"unsigned"},{"column":"data_type"},{"column":"mgo_enum_name"},{"column":"display_key"},{"column":"order_by"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];
        DB::table('mgo_features')->insert($mgoFeatures);
    }
}
