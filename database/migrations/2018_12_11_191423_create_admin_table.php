<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('username', 20)->comment('用户名');
            $table->string('password', 32)->comment('密码');
            $table->string('nicename', 20)
                ->default('')
                ->comment('昵称');
            $table->dateTime('regtime')->comment('注册时间');
            $table->tinyInteger('status')
                ->default('1')
                ->comment('状态：1：正常，0：禁用');
            $table->smallInteger('admin_group_id', false, true)->comment('admin_group表 id');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('username', 'username');
            $table->index('admin_group_id', 'admin_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
