<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMgoFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mgo_module_id')->unsigned()->comment('关联定义模块(模块ID)');
            // $table->string('display_name')->comment('显示名称');
            $table->string('name')->comment('功能名称');
            $table->string('type')->comment('功能类型(add,delete,update,view,share,...)');
            $table->text('attr')->nullable()->comment('功能属性(add:{...},update:[{column:name,edit:false},{column:logo,edit:true}])');
            $table->timestamps();

            $table->foreign('mgo_module_id')->references('id')->on('mgo_modules')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
        DB::statement("ALTER TABLE `mgo_features` comment '定义功能'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_features');
    }
}
