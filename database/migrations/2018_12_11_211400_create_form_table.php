<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50)->comment('表单名称');
            $table->string('no', 32)->comment('表单编号');
            $table->string('table', 20)->comment('表名');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('表单排序，升序');
            $table->string('sort', 50)
                ->default('id DESC')
                ->comment('内容排序');
            $table->tinyInteger('display')
                ->default(0)
                ->comment('是否在前台显示此表单的分页列表内容，0：否，1：是');
            $table->smallInteger('page', false, true)
                ->default(10)
                ->comment('前台分页数');
            $table->string('tpl', 50)
                ->default('')
                ->comment('前台模板，为空使用默认模板');
            $table->string('condition', 255)
                ->default('')
                ->comment('前台分页条件');
            $table->tinyInteger('return_type')
                ->default(0)
                ->comment('提交表单返回类型，0：JS消息框，1：json');
            $table->string('return_msg', 255)
                ->default('提交成功')
                ->comment('提交成功后返回的提示信息');
            $table->string('return_url', 255)
                ->default('')
                ->comment('提交成功后跳转的地址');
            $table->tinyInteger('is_captcha')
                ->default(0)
                ->comment('是否使用图片验证码，0：否，1：是');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('name', 'name');
            $table->unique('no', 'no');
            $table->unique('table', 'table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form');
    }
}
