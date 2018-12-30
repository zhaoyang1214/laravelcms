<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpandTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expand', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('table', 50)->comment('模型表名称');
            $table->string('name', 50)->comment('模型名称');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('扩展模型排序，升序');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('table', 'table');
            $table->unique('name', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expand');
    }
}
