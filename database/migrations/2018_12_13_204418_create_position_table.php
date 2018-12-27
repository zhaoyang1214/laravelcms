<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50)->comment('名称');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('排序，升序');
            $table->index('name', 'name');
            $table->index('sequence', 'sequence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position');
    }
}
