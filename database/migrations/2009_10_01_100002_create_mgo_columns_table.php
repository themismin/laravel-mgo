<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgo_columns', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mgo_table_name')->comment('关联定义表属性(定义表属性表名称)');

            $table->string('name')->comment('列名称');
            $table->string('display_name')->comment('显示名称');
            $table->string('type')->comment('列类型');
            $table->integer('length')->nullable()->comment('列长度');
            $table->integer('decimals')->nullable()->comment('小数点长度');
            $table->boolean('not_null')->default(0)->comment('是否不为空');
            $table->string('default')->nullable()->comment('默认值');
            $table->string('comment')->comment('备注');

            $table->boolean('auto_increment')->default(0)->comment('是否自增');
            $table->boolean('unsigned')->default(0)->comment('是否无符号');

            $table->string('data_type')->default('text')->comment('数据类型(text:文本,rich_text:富文本,image:图片,audio:音频,video:视频,has_one:对一关联,has_many:对多关联)');
            $table->boolean('display_key')->default(0)->comment('是否展示键');
            $table->bigInteger('order_by')->default(0)->comment('排序');

            $table->timestamps();

            $table->unique(['mgo_table_name', 'name']);
            $table->foreign('mgo_table_name')->references('name')->on('mgo_tables')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });

        DB::statement("ALTER TABLE `mgo_columns` comment '定义列属性'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgo_columns');
    }
}
