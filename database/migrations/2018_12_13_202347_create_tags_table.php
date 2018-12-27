<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('tags_group_id', false, true)
                ->default(0)
                ->comment('tags_group表id');
            $table->string('name', 100)->comment('标签名');
            $table->integer('click', false, true)
                ->default(0)
                ->comment('点击次数');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->index('tags_group_id', 'tags_group_id');
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
        Schema::dropIfExists('tags');
    }
}
