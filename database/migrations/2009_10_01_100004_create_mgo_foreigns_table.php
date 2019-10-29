<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoForeignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_foreigns', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mgo_table_name')->comment('关联定义表属性(定义表属性表名称)');

            $table->string('name')->comment('外键名称');

            $table->string('field')->comment('外键字段(关联定义列属性)(定义列属性列名称)');
            $table->bigInteger('field_id')->unsigned()->comment('外键字段ID(关联定义列属性)(定义列属性列ID)');

            $table->string('referenced_table_name')->comment('外键关联表(关联定义表属性)(定义表属性表名称)');
            $table->string('referenced_field')->comment('外键关联字段(关联定义列属性)(定义列属性列名称)');
            $table->bigInteger('referenced_field_id')->unsigned()->comment('外键关联字段ID(关联定义列属性)(定义列属性列ID)');

            $table->string('on_update')->default('CASCADE')->comment('更新约束(CASCADE,SET NULL,RESTRICT,NO ACTION)');
            $table->string('on_delete')->default('RESTRICT')->comment('删除约束(CASCADE,SET NULL,RESTRICT,NO ACTION)');
            $table->timestamps();

            $table->foreign('mgo_table_name')->references('name')->on('mgo_tables')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('field_id')->references('id')->on('mgo_columns')->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('referenced_table_name')->references('name')->on('mgo_tables')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('referenced_field_id')->references('id')->on('mgo_columns')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
        DB::statement("ALTER TABLE `mgo_foreigns` comment '定义外键属性'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_foreigns');
    }
}
