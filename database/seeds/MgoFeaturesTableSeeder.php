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
            ['mgo_module_id' => '1', 'name' => '新增', 'type' => 'create', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_module_id' => '1', 'name' => '删除', 'type' => 'destroy', 'attr' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_module_id' => '1', 'name' => '修改', 'type' => 'edit', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_module_id' => '1', 'name' => '详情', 'type' => 'show', 'attr' => '{"columns":[{"column":"name"},{"column":"display_name"},{"column":"model_class"},{"column":"comment"},{"column":"migrate"}]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_features')->insert($mgoFeatures);
    }
}
