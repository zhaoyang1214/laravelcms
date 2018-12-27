<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPageTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_page', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('category_id', false, true)->comment('category表id');
            $table->text('content')->comment('内容');
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
        Schema::dropIfExists('category_page');
    }
}
