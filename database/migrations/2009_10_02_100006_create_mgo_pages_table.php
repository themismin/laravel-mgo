<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_pages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('mgo_guard_id')->unsigned()->comment('关联定义守卫(守卫ID)');

            // $table->string('display_name')->comment('显示名称');
            $table->string('name')->comment('页面名称');

            $table->timestamps();

            // $table->unique(['name']);

            $table->foreign('mgo_guard_id')->references('id')->on('mgo_guards')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
        DB::statement("ALTER TABLE `mgo_enum_values` comment '定义页面'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_pages');
    }
}
