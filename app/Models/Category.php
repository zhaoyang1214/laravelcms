<?php
namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Overtrue\Pinyin\Pinyin;
use Psr\SimpleCache\InvalidArgumentException;

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

    /**
     * 获取单条记录，允许缓存
     *
     * @param string|array|\Closure|int $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Model|object|static|null|bool
     */
    public static function getInfoCache(
        $column,
        $operator = null,
        $value = null,
        string $boolean = 'and',
        array $columns = ['*']
    ) {
        if (is_numeric($column)) {
            $operator = $column;
            $column = 'id';
        }
        $instance = static::query()->where('is_show', 1)->where($column, $operator, $value, $boolean);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $cacheKey = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $columns]);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        $result = $instance->first($columns);
        if (!empty($result)) {
            $result->url = '/category/' . $result->urlname;
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($cacheKey, $result, $ttl);
        }
        return $result;
    }

    /**
     * 获取简单的记录数，根据系统设置缓存
     *
     * @param string|array|\Closure|null $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return int
     */
    public static function getCountCache(
        $column = null,
        $operator = null,
        $value = null,
        string $boolean = 'and',
        array $columns = ['*']
    ) {
        $instance = static::query()->where('is_show', 1);
        if (!is_null($column)) {
            $instance =$instance->where($column, $operator, $value, $boolean);
        }
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $columns, 'count']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $result = $instance->count($columns);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $result, $ttl);
        }
        return $result;
    }

    /**
     * 获取多条记录数，根据系统设置缓存
     *
     * @param string|array|\Closure|null $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param int $limit
     * @param int $offset
     * @param string|null $orderBy
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getListCache(
        $column = null,
        $operator = null,
        $value = null,
        $boolean = 'and',
        $limit = null,
        $offset = null,
        $orderBy = null,
        $columns = ['*']
    ) {
        $query = static::query()->where('is_show', 1);
        if (!is_null($column)) {
            $query = $query->where($column, $operator, $value, $boolean);
        }
        $orderBy = 'sequence ASC' . (isset($orderBy) ? ',' . $orderBy : '');
        $query = $query->orderByRaw($orderBy);
        if (isset($limit)) {
            $query = $query->limit($limit);
        }
        if (isset($offset)) {
            $query = $query->offset($offset);
        }
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $columns, 'list']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->get($columns);
        if (!empty($list)) {
            foreach ($list as $item) {
                $item->url = '/category/' . $item->urlname;
            }
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取栏目分组
     * 修改日期：2019/8/18
     *
     * @param int $id
     * @param int|null $maxDepth
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return array
     */
    public function getGroup(int $id = 0, int $maxDepth = null)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([__class__, __method__, $id, $maxDepth]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = self::getListCache();
        if (!empty($list)) {
            $list = $list->toArray();
        } else {
            $list = [];
        }
        $toolsCategory = new \App\Library\Tools\Category($list);
        $list = $toolsCategory->setMaxDepth($maxDepth)->categoryGroup($id);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取自身及父级栏目
     * 修改日期：2019/8/18
     *
     * @param int $id
     * @param int|null $maxDepth
     * @param bool $keepSelf
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return Category[]|array|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getParents(int $id = 0, int $maxDepth = null, bool $keepSelf = true)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([__class__, __method__, $id, $maxDepth]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = self::getListCache();
        if (!empty($list)) {
            $list = $list->toArray();
        } else {
            $list = [];
        }
        $toolsCategory = new \App\Library\Tools\Category($list);
        $parents = $toolsCategory->setMaxDepth($maxDepth)->getParents($id);
        $list = array_reverse($parents);
        if (!$keepSelf) {
            array_pop($list);
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取子栏目
     * 修改日期：2019/8/18
     *
     * @param int $id
     * @param int|null $maxDepth
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return Category[]|array|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getSons(int $id = 0, int $maxDepth = null)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([__class__, __method__, $id, $maxDepth]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = self::getListCache();
        if (!empty($list)) {
            $list = $list->toArray();
        } else {
            $list = [];
        }
        $toolsCategory = new \App\Library\Tools\Category($list);
        $list = $toolsCategory->setMaxDepth($maxDepth)->getSons($id);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取顶级父栏目
     * 修改日期：2019/8/18
     *
     * @param int $id
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return Category|array|mixed
     */
    public function getTopCategory(int $id)
    {
        $list = self::getParents($id);
        return $list[0] ?? [];
    }

    /**
     * 功能：获取父栏目
     * 修改日期：2019/8/18
     *
     * @param int $id
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return mixed
     */
    public function getParent(int $id)
    {
        $list = self::getParents($id, 2, false);
        return end($list);
    }
}
