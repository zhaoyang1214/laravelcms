<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAuthTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_auth', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 20)->comment('权限名称');
            $table->smallInteger('pid', false, true)
                ->default(0)
                ->comment('父id');
            $table->string('controller', 20)
                ->default('')
                ->comment('控制器');
            $table->string('action', 20)
                ->default('')
                ->comment('操作方法');
            $table->smallInteger('sequence')
                ->default('0')
                ->comment('排序，越小越排在前面');
            $table->string('note', 20)
                ->default('')
                ->comment('备注');
            $table->string('icon', 50)
                ->default('')
                ->comment('图标');
            $table->tinyInteger('status')
                ->default('1')
                ->comment('状态：0：隐藏，1：显示');
            $table->index([
                'pid',
                'status'
            ], 'pid_status');
            $table->index([
                'controller',
                'action',
                'status'
            ], 'controller_action_status');
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
        Schema::dropIfExists('admin_auth');
    }
}