<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMgoEnumValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_enum_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mgo_enum_name')->comment('关联定义枚举(枚举名称)');
            $table->string('name')->comment('枚举值名称');
            $table->string('display_name')->comment('显示名称');
            $table->timestamps();

            $table->foreign('mgo_enum_name')->references('name')->on('mgo_enums')->onUpdate('CASCADE')->onDelete('RESTRICT');

        });
        DB::statement("ALTER TABLE `mgo_enum_values` comment '定义枚举值'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_enum_values');
    }
}
