<?php
namespace App\Models;

use Illuminate\Support\Facades\Cache;
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

    public $timestamps = false;

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
        'taglink',
        'input_time',
        'update_time'
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
            return $this->appendMessage('该内容url已存在');
        }
        $nowDate = date('Y-m-d H:i:s');
        if (empty($data['update_time'])) {
            $data['update_time'] = $nowDate;
        }
        if (!empty($data['position']) && is_array($data['position'])) {
            $data['position'] = implode(',', $data['position']);
        }
        $data['input_time'] = $nowDate;
        return self::create($data);
    }

    public function edit($id, $data)
    {
        $info = self::find($id);
        if (empty($info)) {
            return $this->appendMessage('内容不存在');
        }
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
        if (self::where('urltitle', $data['urltitle'])->where('id', '<>', $id)->count()) {
            return $this->appendMessage('该内容url已存在');
        }
        if (empty($data['update_time'])) {
            $data['update_time'] = date('Y-m-d H:i:s');
        }
        $data['position'] = isset($data['position']) ? implode(',', $data['position']) : '';
        $info->update_time = $data['update_time'];
        $res = $info->fill($data)->save();
        return $res === false ? false : $info;
    }

    /**
     * 功能：获取内容列表
     * 修改日期：2019/8/21
     *
     * @param array $categoryIds
     * @param int $listRows
     * @param int $expandId
     * @param int $order
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getContentList(array $categoryIds, int $listRows, int $expandId = 0, int $order = 1)
    {
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')->leftJoin('category as b', 'a.category_id', 'b.id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        if ($expandId) {
            $expand = Expand::getInfoCache($expandId);
            $expandDataTable = (new ExpandData($expand->table))->getTable();
            $expandFieldList = ExpandField::getListCache('expand_id', $expandId)->toArray();
            $expandFields = array_column($expandFieldList, 'field');
            foreach ($expandFields as $expandField) {
                $columns[] = 'c.' . $expandField;
            }
            $query->leftJoin("{$expandDataTable} as c", 'c.content_id', 'a.id');
        }
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->whereIn('a.category_id', $categoryIds)
            ->where('a.status', 1);
        switch ($order) {
            case 2:
                $query = $query->orderBy('a.update_time');
                break;
            case 3:
                $query = $query->orderByDesc('a.id');
                break;
            case 4:
                break;
            case 5:
                $query = $query->orderByDesc('a.sequence');
                break;
            case 6:
                $query = $query->orderBy('a.sequence');
                break;
            case 1:
            default:
                $query = $query->orderByDesc('a.update_time');
        }
        $query = $query->orderBy('a.id');
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, 'getContentList']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }
}
