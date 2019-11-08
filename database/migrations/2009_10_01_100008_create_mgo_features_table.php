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
            $table->bigInteger('mgo_module_id')->comment('模块ID');
            $table->string('name')->comment('功能名称');
            $table->string('type')->comment('功能类型(index,list,tree,charts,add,delete,update,view,share,...)');
            $table->text('attr')->nullable()->comment('功能属性(list:{column:[title,logo,...],order_by:[created_at,updated_at],search:[title,deleted_at,...]},add:{...},update:[{column:name,edit:false},{column:logo,edit:true}])');
            $table->timestamps();
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
