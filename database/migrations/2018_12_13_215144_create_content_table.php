<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('category_id', false, true)->comment('category表id');
            $table->string('title', 100)
                ->default('')
                ->comment('标题');
            $table->string('urltitle', 100)
                ->default('')
                ->comment('URL路径');
            $table->string('subtitle', 100)
                ->default('')
                ->comment('短标题');
            $table->string('font_color', 7)
                ->default('')
                ->comment('颜色(16进制RGB值)');
            $table->tinyInteger('font_bold')
                ->default(0)
                ->comment('加粗，0：不加粗，1：加粗');
            $table->string('keywords', 255)
                ->default('')
                ->comment('关键词');
            $table->string('description', 255)
                ->default('')
                ->comment('描述');
            $table->dateTime('update_time')->comment('更新时间');
            $table->dateTime('input_time')->comment('发布时间');
            $table->string('image', 255)
                ->default('')
                ->comment('封面图');
            $table->string('jump_url', 255)
                ->default('')
                ->comment('跳转');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('排序');
            $table->string('tpl', 255)
                ->default('')
                ->comment('模板');
            $table->tinyInteger('status')
                ->default(0)
                ->comment('状态，0：草稿，1：发布');
            $table->string('copyfrom', 255)
                ->default('')
                ->comment('来源');
            $table->integer('views', false, true)
                ->default(0)
                ->comment('浏览数');
            $table->string('position', 255)
                ->default(0)
                ->comment('推荐ids');
            $table->tinyInteger('taglink')
                ->default(0)
                ->comment('是否内容自动TAG');
            $table->unique('urltitle', 'urltitle');
            $table->index([
                'category_id',
                'status'
            ], 'category_id_status');
            $table->index('title', 'title');
            $table->index([
                'urltitle',
                'status'
            ], 'urltitle_status');
            $table->index('update_time', 'update_time');
            $table->index('input_time', 'input_time');
            $table->index('views', 'views');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content');
    }
}
