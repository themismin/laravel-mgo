<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoOrderBiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_order_bies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mgo_table_name')->comment('关联定义表属性(定义表属性表名称)');
            $table->string('field')->comment('关联定义列属性(定义列属性列名称)');
            $table->bigInteger('field_id')->unsigned()->comment('关联定义列属性(定义列属性列ID)');

            $table->string('direction')->default('ASC')->comment('排序规则(ASC:正序,DESC:倒序)');

            $table->string('order_by')->comment('排序');

            $table->timestamps();

        });
        DB::statement("ALTER TABLE `mgo_order_bies` comment '定义排序属性'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_order_bies');
    }
}
