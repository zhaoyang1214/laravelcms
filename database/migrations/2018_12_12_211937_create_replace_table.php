<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replace', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('key', 255)->comment('关键字');
            $table->string('content', 255)->comment('要替换的内容');
            $table->smallInteger('num', false, true)
                ->default(0)
                ->comment('替换次数，0：不限制');
            $table->tinyInteger('status')
                ->default(0)
                ->comment('状态，0：禁用，1：启用');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('key', 'key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replace');
    }
}
