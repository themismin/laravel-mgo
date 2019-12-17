<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MgoModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mgo_modules')->truncate();
        $mgoModules = [
            ['mgo_page_id' => '1', 'name' => '列表', 'mgo_table_name' => 'mgo_tables', 'type' => 'list', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}],"order_by":[{"column":"created_at","sort":"ASC"}],"search":[{"column":"name"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_page_id' => '2', 'name' => '列表', 'mgo_table_name' => 'mgo_columns', 'type' => 'list', 'attr' => '{"columns":[{"column":"mgo_table_name"},{"column":"name"},{"column":"display_name"},{"column":"type"},{"column":"length"},{"column":"decimals"},{"column":"not_null"},{"column":"default"},{"column":"comment"},{"column":"auto_increment"},{"column":"unsigned"},{"column":"data_type"},{"column":"mgo_enum_name"},{"column":"display_key"},{"column":"order_by"}],"order_by":[{"column":"created_at","sort":"ASC"}],"search":[{"column":"name"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_modules')->insert($mgoModules);
    }
}
