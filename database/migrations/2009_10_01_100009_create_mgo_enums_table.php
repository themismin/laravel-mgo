<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMgoEnumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_enums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('枚举名称');
            $table->string('alias')->unique()->comment('枚举别名');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `mgo_enums` comment '定义枚举'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_enums');
    }
}
