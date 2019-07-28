<?php
namespace App\Models;

use Overtrue\Pinyin\Pinyin;

/**
 * App\Models\Content
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id category表id
 * @property string $title 标题
 * @property string $urltitle URL路径
 * @property string $subtitle 短标题
 * @property string $font_color 颜色(16进制RGB值)
 * @property int $font_bold 加粗，0：不加粗，1：加粗
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property \Illuminate\Support\Carbon $update_time 更新时间
 * @property \Illuminate\Support\Carbon $input_time 发布时间
 * @property string $image 封面图
 * @property string $jump_url 跳转
 * @property int $sequence 排序
 * @property string $tpl 模板
 * @property int $status 状态，0：草稿，1：发布
 * @property string $copyfrom 来源
 * @property int $views 浏览数
 * @property string $position 推荐ids
 * @property int $taglink 是否内容自动TAG
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereCopyfrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereFontBold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereFontColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereInputTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereJumpUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereTaglink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereTpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereUrltitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereViews($value)
 */
class Content extends BaseModel
{

    protected $table = 'content';

    const CREATED_AT = 'input_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'category_id',
        'title',
        'urltitle',
        'subtitle',
        'font_color',
        'font_bold',
        'keywords',
        'description',
        'image',
        'jump_url',
        'sequence',
        'tpl',
        'status',
        'copyfrom',
        'views',
        'position',
        'taglink'
    ];

    public function add($data)
    {
        if (empty($data['title'])) {
            return $this->appendMessage('标题不能为空');
        }
        if (empty($data['urltitle'])) {
            $pinyin = new Pinyin();
            $urltitle = $pinyin->permalink($data['title'], '');
            if (strlen($urltitle) > 100) {
                $urltitle = substr($urltitle, 0, 68) . md5(substr($urltitle, 68));
            }
            $data['urltitle'] = $urltitle;
        }
        if (self::where('urltitle', $data['urltitle'])->count()) {
            return $this->appendMessage('该栏目url已存在');
        }
        if (empty($data['updatetime'])) {
            $data['updatetime'] = date('Y-m-d H:i:s');
        }
        if (!empty($data['position']) && is_array($data['position'])) {
            $data['position'] = implode(',', $data['position']);
        }
        return self::create($data);
    }
}
