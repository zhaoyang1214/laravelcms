<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTagsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id', false, true)->comment('content表id');
            $table->integer('tags_id', false, true)->comment('tags表id');
            $table->index('content_id', 'content_id');
            $table->index('tags_id', 'tags_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_tags');
    }
}
