<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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
            return $this->appendMessage('英文URL名称');
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
     * 功能：解析order参数
     * 修改日期：2019/9/19
     *
     * @param int|string $order
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return array
     */
    private function parseOrder($order, Builder $query = null)
    {
        $orderArr = [];
        if (is_numeric($order)) {
            switch ($order) {
                case 2:
                    $orderArr[] = ['a.update_time'];
                    break;
                case 3:
                    $orderArr[] = ['a.id', 'desc'];
                    break;
                case 4:
                    $orderArr[] = ['a.id'];
                    break;
                case 5:
                    $orderArr[] = ['a.sequence', 'desc'];
                    break;
                case 6:
                    $orderArr[] = ['a.sequence'];
                    break;
                case 7:
                    $orderArr[] = ['a.views', 'desc'];
                    break;
                case 8:
                    $orderArr[] = ['a.views'];
                    break;
                case 1:
                default:
                    $orderArr[] = ['a.update_time', 'desc'];
            }
            $orderArr[] = ['a.id'];
        } elseif (is_string($order)) {
            $orders = preg_replace('/\s+/', ' ', $order);
            $orders = explode(',', $orders);
            foreach ($orders as $order) {
                $arr = explode(' ', trim($order));
                $orderArr[] = [
                    $arr[0],
                    $arr[1] ?? null
                ];
            }
        }
        if (!is_null($query)) {
            foreach ($orderArr as $v) {
                $query->orderBy(...$v);
            }
        }
        return $orderArr;
    }

    /**
     * 功能：获取内容列表
     * 修改日期：2019/8/21
     *
     * @param array $categoryIds
     * @param int $listRows
     * @param int $expandId
     * @param int|string $order eg 1 or a.update_time desc
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getContentList(array $categoryIds, int $listRows, int $expandId = 0, $order = 1, string $pageName = 'page', $page = null)
    {
        $query = $this->getListQuery($categoryIds, $expandId, $order);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, Paginator::resolveCurrentPage($pageName), 'getContentList']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows, ['*'], $pageName, $page);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取内容列表查询
     * 修改日期：2019/8/21
     *
     * @param array $categoryIds
     * @param int $expandId
     * @param int|string $order eg 1 or a.update_time desc
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Query\Builder
     */
    public function getListQuery(array $categoryIds, int $expandId = 0, $order = 1)
    {
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')->leftJoin('category as b', 'a.category_id', 'b.id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        if ($expandId) {
            $expand = Expand::getInfoCache($expandId);
            $expandDataTable = (new ExpandData())->setTableName($expand->table)->getTable();
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
        $this->parseOrder($order, $query);
        return $query;
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
        $instance = static::query()->where($column, $operator, $value, $boolean)->where('status', 1);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $cacheKey = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $columns]);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        $result = $instance->first($columns);
        if (!empty($result)) {
            $result->url = '/content/' . $result->urltitle;
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($cacheKey, $result, $ttl);
        }
        return $result;
    }

    /**
     * 功能：获取同栏目上一条内容
     * 修改日期：2019/9/15
     *
     * @param array|\Illuminate\Database\Eloquent\Model $content
     * @param array|\Illuminate\Database\Eloquent\Model $category
     * @param int $isArray
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public function getPrevContent($content, $category, int $isArray = 0)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $cacheKey = self::createCacheKey([__METHOD__, $content, $category, $isArray]);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        if (is_object($content)) {
            $content = $content->toArray();
        }
        if (is_object($category)) {
            $category = $category->toArray();
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')->leftJoin('category as b', 'a.category_id', 'b.id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        if ($category['expand_id']) {
            $expand = Expand::getInfoCache($category['expand_id']);
            $expandDataTable = (new ExpandData($expand->table))->getTable();
            $expandFieldList = ExpandField::getListCache('expand_id', $category['expand_id'])->toArray();
            $expandFields = array_column($expandFieldList, 'field');
            foreach ($expandFields as $expandField) {
                $columns[] = 'c.' . $expandField;
            }
            $query->leftJoin("{$expandDataTable} as c", 'c.content_id', 'a.id');
        }
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->where('a.category_id', $category['id'])
            ->where('a.status', 1);
        switch ($category['content_order']) {
            case 2:
                $operators = '<';
                $field = 'update_time';
                $query->orderByDesc('a.update_time')->orderBy('a.id');
                break;
            case 3:
                $operators = '>';
                $field = 'id';
                $query->orderBy('a.id');
                break;
            case 4:
                $operators = '<';
                $field = 'id';
                $query->orderByDesc('a.id');
                break;
            case 5:
                $operators = '>';
                $field = 'sequence';
                $query->orderBy('a.sequence')->orderBy('a.id');
                break;
            case 6:
                $operators = '<';
                $field = 'sequence';
                $query->orderByDesc('a.sequence')->orderBy('a.id');
                break;
            case 1:
            default:
                $operators = '>';
                $field = 'update_time';
                $query->orderBy('a.update_time')->orderBy('a.id');
        }
        $query->where(function (Builder $query) use ($content, $field, $operators) {
            $query->where("a.{$field}", $operators, $content[$field])
                ->orWhere("a.{$field}", $content[$field])
                ->where('a.id', '<', $content['id']);
        });
        $result = $query->first();
        if (!empty($result)) {
            $result->url = '/content/' . $result->urltitle;
            if ($isArray) {
                $result = $result->toArray();
            }
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($cacheKey, $result, $ttl);
        }
        return $result;
    }

    /**
     * 功能：获取同栏目下一条内容
     * 修改日期：2019/9/15
     *
     * @param array|\Illuminate\Database\Eloquent\Model $content
     * @param array|\Illuminate\Database\Eloquent\Model $category
     * @param int $isArray
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public function getNextContent($content, $category, int $isArray = 0)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $cacheKey = self::createCacheKey([__METHOD__, $content, $category, $isArray]);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        if (is_object($content)) {
            $content = $content->toArray();
        }
        if (is_object($category)) {
            $category = $category->toArray();
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')->leftJoin('category as b', 'a.category_id', 'b.id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        if ($category['expand_id']) {
            $expand = Expand::getInfoCache($category['expand_id']);
            $expandDataTable = (new ExpandData($expand->table))->getTable();
            $expandFieldList = ExpandField::getListCache('expand_id', $category['expand_id'])->toArray();
            $expandFields = array_column($expandFieldList, 'field');
            foreach ($expandFields as $expandField) {
                $columns[] = 'c.' . $expandField;
            }
            $query->leftJoin("{$expandDataTable} as c", 'c.content_id', 'a.id');
        }
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->where('a.category_id', $category['id'])
            ->where('a.status', 1);
        switch ($category['content_order']) {
            case 2:
                $operators = '>';
                $field = 'update_time';
                $query->orderBy('a.update_time')->orderBy('a.id');
                break;
            case 3:
                $operators = '<';
                $field = 'id';
                $query->orderByDesc('a.id');
                break;
            case 4:
                $operators = '>';
                $field = 'id';
                $query->orderBy('a.id');
                break;
            case 5:
                $operators = '<';
                $field = 'sequence';
                $query->orderByDesc('a.sequence')->orderBy('a.id');
                break;
            case 6:
                $operators = '>';
                $field = 'sequence';
                $query->orderBy('a.sequence')->orderBy('a.id');
                break;
            case 1:
            default:
                $operators = '<';
                $field = 'update_time';
                $query->orderByDesc('a.update_time')->orderBy('a.id');
        }
        $query->where(function (Builder $query) use ($content, $field, $operators) {
            $query->where("a.{$field}", $operators, $content[$field])
                ->orWhere("a.{$field}", $content[$field])
                ->where('a.id', '<', $content['id']);
        });
        $result = $query->first();
        if (!empty($result)) {
            $result->url = '/content/' . $result->urltitle;
            if ($isArray) {
                $result = $result->toArray();
            }
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($cacheKey, $result, $ttl);
        }
        return $result;
    }

    /**
     * 功能：根据栏目id获取内容
     * 修改日期：2019/9/19
     *
     * @param int|array $categoryIds
     * @param int $listRows
     * @param int|string $order eg 1 or a.update_time desc
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator|mixed
     */
    public function getListByCategoryId($categoryIds, int $listRows = null, $order = null, string $pageName = 'nopage', $page = null)
    {
        $expandId = 0;
        if (is_int($categoryIds)) {
            $category = Category::getInfoCache($categoryIds);
            if (!$category) {
                return new LengthAwarePaginator([], 0, 1);
            }
            if ($category->type == 1) {
                $categorySons = $category->getSons($category->id);
                $categoryIds = array_column($categorySons, 'id');
            } else {
                $categoryIds = [$category->id];
                $listRows = $listRows ?? intval($category->page);
                $order = $order ?? intval($category->content_order);
            }
            $expandId = $category->expand_id;
        }

        return self::getContentList($categoryIds, $listRows ?? 10, $expandId, $order, $pageName, $page);
    }

    /**
     * 功能：根据tags_id获取内容列表
     * 修改日期：2019/9/22
     *
     * @param array|string $tagsIds
     * @param int $listRows
     * @param null|array|string $categoryIds
     * @param bool $categorySon
     * @param null|int|string $order
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getListByTagsIds(
        $tagsIds,
        int $listRows = 10,
        $categoryIds = null,
        bool $categorySon = false,
        $order = null,
        string $pageName = 'nopage',
        $page = null
    ) {
        if (!is_array($tagsIds)) {
            $tagsIds = explode(',', $tagsIds);
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')
            ->leftJoin('category as b', 'a.category_id', 'b.id')
            ->leftJoin('content_tags as c', 'a.id', 'c.content_id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->whereIn('c.tags_id', $tagsIds)
            ->where('a.status', 1);
        if (!is_null($categoryIds)) {
            if (!is_array($categoryIds)) {
                $categoryIds = explode(',', $categoryIds);
            }
            if ($categorySon) {
                $categoryIdArr = $categoryIds;
                $category = new Category();
                foreach ($categoryIdArr as $categoryId) {
                    $sons = $category->getSons(intval($categoryId));
                    if (!empty($sons)) {
                        $sonsIds = array_column($sons, 'id');
                        $categoryIds = array_merge($categoryIds, $sonsIds);
                    }
                }
            }
            $query->whereIn('a.category_id', $categoryIds);
        }
        $order = $order ?? 'a.update_time DESC,a.views DESC,a.id ASC';
        $this->parseOrder($order, $query);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, 'getListByTagsIds']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows, ['*'], $pageName, $page);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：根据position_id获取内容列表
     * 修改日期：2019/9/22
     *
     * @param array|string $positionIds
     * @param int $listRows
     * @param null|array|string $categoryIds
     * @param bool $categorySon
     * @param null|int|string $order
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getListByPositions(
        $positionIds,
        int $listRows = 10,
        $categoryIds = null,
        bool $categorySon = false,
        $order = null,
        $pageName = 'nopage',
        $page = null
    ) {
        if (!is_array($positionIds)) {
            $positionIds = explode(',', $positionIds);
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')
            ->leftJoin('category as b', 'a.category_id', 'b.id')
            ->leftJoin('content_position as c', 'a.id', 'c.content_id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->whereIn('c.position_id', $positionIds)
            ->where('a.status', 1);
        if (!is_null($categoryIds)) {
            if (!is_array($categoryIds)) {
                $categoryIds = explode(',', $categoryIds);
            }
            if ($categorySon) {
                $categoryIdArr = $categoryIds;
                $category = new Category();
                foreach ($categoryIdArr as $categoryId) {
                    $sons = $category->getSons(intval($categoryId));
                    if (!empty($sons)) {
                        $sonsIds = array_column($sons, 'id');
                        $categoryIds = array_merge($categoryIds, $sonsIds);
                    }
                }
            }
            $query->whereIn('a.category_id', $categoryIds);
        }
        $order = $order ?? 'a.update_time DESC,a.views DESC,a.id ASC';
        $this->parseOrder($order, $query);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, 'getListByTagsIds']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows, ['*'], $pageName, $page);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：根据position_id获取内容列表
     * 修改日期：2019/9/22
     *
     * @param array|string $tagsGroupIds
     * @param int $listRows
     * @param null|array|string $categoryIds
     * @param bool $categorySon
     * @param null|int|string $order
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getListByTagsGroupIds(
        $tagsGroupIds,
        int $listRows = 10,
        $categoryIds = null,
        bool $categorySon = false,
        $order = null,
        $pageName = 'nopage',
        $page = null
    ) {
        if (!is_array($tagsGroupIds)) {
            $tagsGroupIds = explode(',', $tagsGroupIds);
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')
            ->leftJoin('category as b', 'a.category_id', 'b.id')
            ->leftJoin('content_tags as c', 'a.id', 'c.content_id')
            ->leftJoin('tags as d', 'c.tags_id', 'd.id');
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];
        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->whereIn('d.tags_group_id', $tagsGroupIds)
            ->where('a.status', 1);
        if (!is_null($categoryIds)) {
            if (!is_array($categoryIds)) {
                $categoryIds = explode(',', $categoryIds);
            }
            if ($categorySon) {
                $categoryIdArr = $categoryIds;
                $category = new Category();
                foreach ($categoryIdArr as $categoryId) {
                    $sons = $category->getSons(intval($categoryId));
                    if (!empty($sons)) {
                        $sonsIds = array_column($sons, 'id');
                        $categoryIds = array_merge($categoryIds, $sonsIds);
                    }
                }
            }
            $query->whereIn('a.category_id', $categoryIds);
        }
        $order = $order ?? 'a.update_time DESC,a.views DESC,a.id ASC';
        $this->parseOrder($order, $query);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, 'getListByTagsIds']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows, ['*'], $pageName, $page);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    /**
     * 功能：获取搜索结果
     * 修改日期：2019/9/22
     *
     * @param string|array $keywords
     * @param int $type
     * @param array|null $categoryIds
     * @param int $listRows
     * @param string $pageName
     * @param int|null $page
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function getListBySearch(
        $keywords,
        int $type = 0,
        array $categoryIds = null,
        int $listRows = 10,
        $pageName = 'page',
        $page = null
    ) {
        if (!is_array($keywords)) {
            $keywords = explode(' ', $keywords);
        }
        $dbPrefix = env('DB_PREFIX');
        $query = static::from('content as a')
            ->leftJoin('category as b', 'a.category_id', 'b.id');
        if ($type == 2) {
            $query->leftJoin('content_data as c', 'a.id', 'c.content_id');
        }
        $columns = ['a.*', 'b.name as category_name', 'b.subname as category_subname', 'b.category_model_id'];

        $query->select($columns)
            ->selectRaw("concat('/content/',{$dbPrefix}a.urltitle) as url")
            ->where('a.status', 1);
        if (!empty($categoryIds)) {
            $query->whereIn('a.category_id', $categoryIds);
        }
        $query->where(function (Builder $query) use ($keywords, $type) {
            foreach ($keywords as $value) {
                switch ($type) {
                    case 1: // 标题+描述+关键词
                        $query->orWhere('a.title', 'like', "%{$value}%")
                            ->orWhere('a.keywords', 'like', "%{$value}%")
                            ->orWhere('a.description', 'like', "%{$value}%");
                        break;
                    case 2: // 标题+描述+关键词+全文
                        $query->orWhere('a.title', 'like', "%{$value}%")
                            ->orWhere('a.keywords', 'like', "%{$value}%")
                            ->orWhere('a.description', 'like', "%{$value}%")
                            ->orWhere('c.content', 'like', "%{$value}%");
                        break;
                    default: // 标题
                        $query->orWhere('a.title', 'like', "%{$value}%");
                        break;
                }
            }
        });
        $query->orderBy('a.update_time')->orderBy('a.id');
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $listRows, 'getListBySearch']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->paginate($listRows, ['*'], $pageName, $page);
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }
}
