<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryModelTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_model', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50)->comment('模型名称');
            $table->string('category', 50)->comment('栏目控制器名');
            $table->string('content', 50)
                ->default('')
                ->comment('栏目控制器名');
            $table->tinyInteger('status')
                ->default(0)
                ->comment('状态，0：禁用，1：开启');
            $table->string('befrom')
                ->default('')
                ->comment('来源');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_model');
    }
}
