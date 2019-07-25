<?php
namespace App\Models;

use Overtrue\Pinyin\Pinyin;

/**
 * App\Models\Category
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $pid 上级栏目id
 * @property int $category_model_id category_model表id
 * @property int $sequence 排序，升序
 * @property int $is_show 是否显示，1：显示，0：隐藏
 * @property int $type 栏目类型，1：频道页，2：列表页
 * @property string $name 栏目名称
 * @property string $urlname 栏目url优化
 * @property string $subname 副栏目名称
 * @property string $image 栏目形象图
 * @property string $category_tpl 栏目模板
 * @property string $content_tpl 内容模板
 * @property int $page 内容分页数
 * @property string $keywords 关键词，","分割
 * @property string $description 描述
 * @property string $seo_content SEO内容
 * @property int $content_order 内容排序，1:更新时间 新旧("updatetime DESC")；2:更新时间 旧新("updatetime ASC")；3：发布时间 新旧("inputtime DESC")；4:发布时间 旧新("inputtime ASC")；5：自定义顺序 大小("sequence DESC")；6：自定义顺序 小大("sequence ASC")
 * @property int $expand_id 扩展表id
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCategoryModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCategoryTpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereContentOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereContentTpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereExpandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSeoContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSubname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUrlname($value)
 */
class Category extends BaseModel
{

    protected $table = 'category';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'pid',
        'category_model_id',
        'sequence',
        'is_show',
        'type',
        'name',
        'urlname',
        'subname',
        'image',
        'category_tpl',
        'content_tpl',
        'page',
        'keywords',
        'description',
        'seo_content',
        'content_order',
        'expand_id'
    ];

    public static function getAllowCount()
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['category_ids']));
        }
        return $query->count();
    }

    public static function getAllowList()
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['category_ids']));
        }
        $list = $query->orderBy('sequence')
            ->get()
            ->toArray();
        if (empty($list)) {
            return [];
        }
        $toolsCategory = new \App\Library\Tools\Category($list, [
            'title' => 'name',
            'fulltitle' => 'cname'
        ]);
        return $toolsCategory->reclassify();
    }

    public function add($data)
    {
        if (empty($data['name'])) {
            return $this->appendMessage('栏目名称不能为空');
        }
        if (empty($data['urlname'])) {
            $pinyin = new Pinyin();
            $urlname = $pinyin->permalink($data['name'], '');
            if (strlen($urlname) > 100) {
                $urlname = substr($urlname, 0, 68) . md5(substr($urlname, 68));
            }
            $data['urlname'] = $urlname;
        }
        if (self::where('urlname', $data['urlname'])->count()) {
            return $this->appendMessage('该栏目url已存在');
        }
        if (isset($data['keywords'])) {
            $data['keywords'] = str_replace('，', ',', $data['keywords']);
        }
        return self::create($data);
    }

    public function edit($data)
    {
        $category = self::find(intval($data['id']));
        if (empty($category)) {
            return $this->appendMessage('栏目不存在');
        }
        if (empty($data['name'])) {
            return $this->appendMessage('栏目名称不能为空');
        }
        if (empty($data['urlname'])) {
            $pinyin = new Pinyin();
            $urlname = $pinyin->permalink($data['name'], '');
            if (strlen($urlname) > 100) {
                $urlname = substr($urlname, 0, 68) . md5(substr($urlname, 68));
            }
            $data['urlname'] = $urlname;
        }
        if (self::where('urlname', $data['urlname'])->where('id', '<>', $data['id'])->count()) {
            return $this->appendMessage('该栏目url已存在');
        }
        if (isset($data['keywords'])) {
            $data['keywords'] = str_replace('，', ',', $data['keywords']);
        }
        return $category->fill($data)->save();
    }
}
