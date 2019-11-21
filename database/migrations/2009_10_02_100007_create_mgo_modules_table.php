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

            $table->bigInteger('mgo_page_id')->unsigned()->comment('关联定义页面(页面ID)');
            // $table->string('display_name')->comment('显示名称');
            $table->string('name')->comment('模块名称');
            $table->string('mgo_table_name')->comment('模块主表名(关联定义表属性)(表名)');
            $table->string('type')->comment('模块类型(index,list,tree,charts,view)');
            $table->text('attr')->nullable()->comment('模块属性(list:{column:[title,logo,...],order_by:[created_at,updated_at],search:[title,deleted_at,...]})');
            $table->bigInteger('order_by')->default(0)->comment('排序');

            $table->timestamps();
            // $table->unique(['name']);

            $table->foreign('mgo_page_id')->references('id')->on('mgo_pages')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('mgo_table_name')->references('name')->on('mgo_tables')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
