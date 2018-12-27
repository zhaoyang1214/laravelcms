<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('admin_id', false, true)->comment('表admin id');
            $table->dateTime('logintime')->comment('登录时间');
            $table->string('ip', 64)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_log');
    }
}
