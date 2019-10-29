<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_indices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mgo_table_name')->comment('关联定义表属性(定义表属性表名称)');

            $table->string('name')->comment('索引名称');
            $table->string('fields')->comment('索引字段(["name"])');
            $table->string('type')->comment('索引类型("PRIMARY", "UNIQUE")');
            $table->string('method')->default('BTREE')->comment('索引算法(BTREE, HASH)');
            $table->string('comment')->comment('备注');
            $table->timestamps();

            $table->foreign('mgo_table_name')->references('name')->on('mgo_tables')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
        DB::statement("ALTER TABLE `mgo_indices` comment '定义索引属性'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_indices');
    }
}
