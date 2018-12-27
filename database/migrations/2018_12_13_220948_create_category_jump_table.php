<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryJumpTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_jump', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('category_id', false, true)->comment('category表id');
            $table->string('url', 255)
                ->default('')
                ->comment('跳转地址');
            $table->unique('category_id', 'category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_jump');
    }
}
