<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_tables', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('表名称');
            $table->string('display_name')->comment('显示名称');
            $table->string('model_class')->comment('模型类名');
            $table->string('comment')->nullable()->comment('备注');
            $table->string('migrate')->nullable()->comment('迁移文件');

            $table->timestamps();

            $table->unique(['name']);
        });

        DB::statement("ALTER TABLE `mgo_tables` comment '定义表属性'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_tables');
    }
}
