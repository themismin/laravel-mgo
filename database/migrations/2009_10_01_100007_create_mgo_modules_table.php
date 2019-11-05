<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMgoModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('模块名称');
            $table->string('mgo_table_name')->comment('模块主表名称');
            $table->string('default_type')->comment('默认类型(index,list,tree,charts,view)');
            $table->timestamps();
    });
        DB::statement("ALTER TABLE `mgo_modules` comment '定义模块'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_modules');
    }
}
