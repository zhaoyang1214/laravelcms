<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentPositionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_position', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id', false, true)->comment('content表id');
            $table->smallInteger('position_id', false, true)->comment('position表id');
            $table->index('content_id', 'content_id');
            $table->index('position_id', 'position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_position');
    }
}
