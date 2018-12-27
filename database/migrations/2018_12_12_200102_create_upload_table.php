<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file', 255)->comment('文件');
            $table->string('folder', 255)
                ->default('')
                ->comment('文件路径');
            $table->string('title', 255)->comment('文件名');
            $table->string('ext', 20)->comment('文件扩展名');
            $table->integer('size', false, true)
                ->default(0)
                ->comment('文件大小');
            $table->string('type', 255)
                ->default('')
                ->comment('文件类型');
            $table->dateTime('time')->comment('上传时间');
            $table->tinyInteger('module')
                ->default(- 1)
                ->comment('所属模块，-1:未绑定模块；1：栏目模块，2：内容模块，3：扩展模块，4：表单模块');
            $table->index('title', 'title');
            $table->index('ext', 'ext');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload');
    }
}
