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
        ];
        DB::table('mgo_modules')->insert($mgoModules);
    }
}
