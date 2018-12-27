<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpandFieldTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expand_field', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('expand_id', false, true)->comment('expand表id');
            $table->string('name', 50)->comment('字段描述');
            $table->string('field', 50)->comment('字段名');
            $table->tinyInteger('type')
                ->default(1)
                ->comment('字段类型，1：文本框；2：多行文本；3：编辑器，4：文件上传；5：单图片上传；6：组图上传；7：下拉菜单；8：单选；9：多选');
            $table->tinyInteger('property')
                ->default(1)
                ->comment('字段属性，1：varchar；2：int；3：text；4：datetime；5：decimal；');
            $table->smallInteger('len', false, true)
                ->default(0)
                ->comment('长度');
            $table->tinyInteger('decimal', false, true)->comment('小数点位数');
            $table->string('default', 255)
                ->default('')
                ->comment('默认值');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('排序，越小越排在前面');
            $table->string('tip', 255)
                ->default('')
                ->comment('字段提示');
            $table->string('config', 255)
                ->default('')
                ->comment('其他配置');
            $table->tinyInteger('is_must')
                ->default(0)
                ->comment('是否必填，0：否，1：是');
            $table->tinyInteger('is_index')
                ->default(0)
                ->comment('是否添加普通索引，0：否，1：是');
            $table->string('regex', 50)
                ->default('')
                ->comment('正则表达式验证');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique([
                'name',
                'expand_id'
            ], 'name_expand_id');
            $table->unique([
                'field',
                'expand_id'
            ], 'field_expand_id');
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
        Schema::dropIfExists('expand_field');
    }
}
