<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('pid', false, true)
                ->default(0)
                ->comment('上级栏目id');
            $table->tinyInteger('category_model_id', false, true)
                ->default(1)
                ->comment('category_model表id');
            $table->smallInteger('sequence')
                ->default(0)
                ->comment('排序，升序');
            $table->tinyInteger('is_show')
                ->default(1)
                ->comment('是否显示，1：显示，0：隐藏');
            $table->tinyInteger('type')
                ->default(1)
                ->comment('栏目类型，1：频道页，2：列表页');
            $table->string('name', 100)->comment('栏目名称');
            $table->string('urlname', 255)->comment('栏目url优化');
            $table->string('subname', 255)
                ->default('')
                ->comment('副栏目名称');
            $table->string('image', 255)
                ->default('')
                ->comment('栏目形象图');
            $table->string('category_tpl', 255)
                ->default('')
                ->comment('栏目模板');
            $table->string('content_tpl', 255)
                ->default('')
                ->comment('内容模板');
            $table->tinyInteger('page', false, true)
                ->default(10)
                ->comment('内容分页数');
            $table->string('keywords', 255)
                ->default('')
                ->comment('关键词，","分割');
            $table->string('description', 255)
                ->default('')
                ->comment('描述');
            $table->string('seo_content', 255)
                ->default('')
                ->comment('SEO内容');
            $table->tinyInteger('content_order', false, true)
                ->default(1)
                ->comment('内容排序，1:更新时间 新旧("updatetime DESC")；2:更新时间 旧新("updatetime ASC")；3：发布时间 新旧("inputtime DESC")；4:发布时间 旧新("inputtime ASC")；5：自定义顺序 大小("sequence DESC")；6：自定义顺序 小大("sequence ASC")');
            $table->smallInteger('expand_id', false, true)
                ->default(0)
                ->comment('扩展表id');
            $table->dateTime('create_time')->comment('创建时间');
            $table->dateTime('update_time')
                ->nullable()
                ->comment('修改时间');
            $table->unique('urlname', 'urlname');
            $table->index('pid', 'pid');
            $table->index('category_model_id', 'category_model_id');
            $table->index('name', 'name');
            $table->index('sequence', 'sequence');
            $table->index('expand_id', 'expand_id');
            $table->index([
                'urlname',
                'is_show'
            ], 'urlname_is_show');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
