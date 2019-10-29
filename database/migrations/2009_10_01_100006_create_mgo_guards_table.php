<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoGuardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_guards', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('display_name')->comment('显示名称');
            $table->string('name')->comment('守卫名称');

            $table->timestamps();

            $table->unique(['name']);
        });

        DB::statement("ALTER TABLE `mgo_guards` comment '定义守卫属性'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_guards');
    }
}
