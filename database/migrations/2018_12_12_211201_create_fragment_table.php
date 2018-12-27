<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFragmentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fragment', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('sign', 32)->comment('标识');
            $table->string('title', 100)->comment('描述');
            $table->text('content')->comment('内容');
            $table->tinyInteger('rm_html')
                ->default(0)
                ->comment('去除html标签，0：否，1：去除最外层p标签；2:去除所有html标签');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('sign', 'sign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fragment');
    }
}
