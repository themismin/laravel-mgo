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
            $table->string('mgo_enum_alias')->comment('枚举别名');
            $table->string('name')->comment('枚举值名称');
            $table->string('alias')->comment('枚举值别名');
            $table->timestamps();
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
