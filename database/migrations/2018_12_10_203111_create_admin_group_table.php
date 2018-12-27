<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_group', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('pid', false, true)
                ->default('0')
                ->comment('上级 id');
            $table->string('name', 50)->comment('角色名称');
            $table->string('admin_auth_ids', 2000)
                ->default('')
                ->comment('操作权限ids,1,2,5');
            $table->string('category_ids', 1000)
                ->default('')
                ->comment('栏目权限');
            $table->string('form_ids', 1000)
                ->default('')
                ->comment('表单权限');
            $table->tinyInteger('grade')
                ->default('99')
                ->comment('等级，数字越小等级越高');
            $table->tinyInteger('keep')
                ->default('0')
                ->comment('是否校验权限（允许组合），0：全部校验，1：不校验表单权限，2：不校验栏目权限，4：不校验功能权限，7：全部不校验');
            $table->smallInteger('admin_id', false, true)
                ->default('0')
                ->comment('admin表 id，创建者id');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('name', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_group');
    }
}
