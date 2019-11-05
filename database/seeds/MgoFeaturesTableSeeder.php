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
            ['mgo_module_id' => '1', 'name' => '列表', 'type' => 'list', 'attr' => '{"column":["name","display_name"],"order_by":[{"column":"created_at","sort":"ASC"}],"search":["name"]}', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['mgo_module_id' => '1', 'name' => '删除', 'type' => 'delete', 'attr' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('mgo_features')->insert($mgoFeatures);
    }
}
