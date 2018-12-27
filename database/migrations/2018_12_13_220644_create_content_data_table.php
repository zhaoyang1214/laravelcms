<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentDataTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id', false, true)->comment('content表id');
            $table->text('content');
            $table->unique('content_id', 'content_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_data');
    }
}
