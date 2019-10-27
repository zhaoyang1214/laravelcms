<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    /**
     * @var string 表名
     */
    protected $table;

    protected static $tableName = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!is_null(self::$tableName)) {
            $this->table = self::$tableName;
        }
    }

    /**
     * 错误信息
     */
    protected $errorMessages = [];

    /**
     * 功    能：添加错误信息
     * 修改日期：2019/7/25
     *
     * @param string $message
     * @param int $code
     * @return bool
     */
    public function appendMessage(string $message, int $code = 0)
    {
        $this->errorMessages[] = [
            'code' => $code,
            'message' => $message
        ];
        return false;
    }

    /**
     * 获取全部错误信息
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->errorMessages;
    }

    /**
     * 创建缓存Key
     *
     * @param array $params
     * @return string
     */
    public static function createCacheKey(array $params)
    {
        return md5(serialize($params));
    }

    /**
     * 获取单条记录，允许缓存
     *
     * @param string|array|\Closure|int $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param bool $cache
     * @param null|int|\DateInterval $ttl
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Model|object|static|null|bool
     */
    public static function getInfo(
        $column,
        $operator = null,
        $value = null,
        string $boolean = 'and',
        bool $cache = true,
        $ttl = 7200,
        array $columns = ['*']
    ) {
        if (is_numeric($column)) {
            $operator = $column;
            $column = 'id';
        }
        $instance = static::query()->where($column, $operator, $value, $boolean);
        if ($cache) {
            $key = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $columns]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $result = $instance->first($columns);
        if ($cache) {
            Cache::set($key, $result, $ttl);
        }
        return $result;
    }

    /**
     * 获取简单的单条记录，根据系统设置缓存
     *
     * @param string|array|\Closure|int $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public static function getInfoCache(
        $column,
        $operator = null,
        $value = null,
        string $boolean = 'and',
        array $columns = ['*']
    ) {
        $cacheSwitch = (bool)config('system.db_cache');
        $ttl = intval(config('system.db_cache_time')) / 60;
        return self::getInfo($column, $operator, $value, $boolean, $cacheSwitch, $ttl, $columns);
    }

    /**
     * 获取记录数
     *
     * @param string|array|\Closure $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param bool $cache
     * @param null|int|\DateInterval $ttl
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return int
     */
    public static function getCount(
        $column = null,
        $operator = null,
        $value = null,
        string $boolean = 'and',
        bool $cache = true,
        $ttl = 7200,
        array $columns = ['*']
    ) {
        $instance = static::query();
        if (!is_null($column)) {
            $instance = $instance->where($column, $operator, $value, $boolean);
        }
        if ($cache) {
            $key = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $columns, 'count']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $result = $instance->count($columns);
        if ($cache) {
            Cache::set($key, $result, $ttl);
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
        $cacheSwitch = (bool)config('system.db_cache');
        $ttl = intval(config('system.db_cache_time')) / 60;
        return self::getCount($column, $operator, $value, $boolean, $cacheSwitch, $ttl, $columns);
    }

    /**
     * 获取多条记录数
     *
     * @param string|array|\Closure|null $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @param int $limit
     * @param int $offset
     * @param string|null $orderBy
     * @param bool $cache
     * @param null|int|\DateInterval $ttl
     * @param array $columns
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getList(
        $column = null,
        $operator = null,
        $value = null,
        $boolean = 'and',
        $limit = null,
        $offset = null,
        $orderBy = null,
        $cache = true,
        $ttl = 7200,
        $columns = ['*']
    ) {
        $query = static::query();
        if (!is_null($column)) {
            $query = $query->where($column, $operator, $value, $boolean);
        }
        if (isset($orderBy)) {
            $query = $query->orderByRaw($orderBy);
        }
        if (isset($limit)) {
            $query = $query->limit($limit);
        }
        if (isset($offset)) {
            $query = $query->offset($offset);
        }
        if ($cache) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), $columns, 'list']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->get($columns);
        if ($cache) {
            Cache::set($key, $list, $ttl);
        }
        return $list;
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
        $cacheSwitch = (bool)config('system.db_cache');
        $ttl = intval(config('system.db_cache_time')) / 60;
        return self::getList(
            $column,
            $operator,
            $value,
            $boolean,
            $limit,
            $offset,
            $orderBy,
            $cacheSwitch,
            $ttl,
            $columns
        );
    }

    /**
     * 功    能：设置表名并返回模型对象
     * 修改日期：2019/8/7
     *
     * @param string $table 表名
     * @return $this
     */
    public function table(string $table)
    {
        self::$tableName = $table;
        return $this;
    }

    /**
     * 功    能：返回模型
     * 修改日期：2019/8/7
     *
     * @param string $modelName
     * @param mixed $init
     * @return bool
     */
    public function getModel(string $modelName, ...$init)
    {
        self::$tableName = null;
        $class = 'App\\Models\\' . ucfirst($modelName);
        if (class_exists($class)) {
            return new $class(...$init);
        }
        return false;
    }

    /**
     * 功    能：cacheFirst别名
     * 修改日期：2019/8/7
     *
     * @param \Illuminate\Database\Eloquent\Builder $instance Builder
     * @param array $columns
     * @throws  \Exception
     * @return \Illuminate\Database\Eloquent\Model|object|static|null|bool
     */
    public function cacheOne(Builder $instance, array $columns = ['*'])
    {
        return $this->cacheFirst($instance, $columns);
    }

    /**
     * 功    能：查询单条记录（带缓存）
     * 修改日期：2019/8/7
     *
     * @param \Illuminate\Database\Eloquent\Builder $instance Builder
     * @param array $columns
     * @throws  \Exception
     * @return \Illuminate\Database\Eloquent\Model|object|static|null|bool
     */
    public function cacheFirst(Builder $instance, array $columns = ['*'])
    {
        return $this->cacheQuery($instance, 'first', $columns);
    }

    /**
     * 功能：查询总记录数
     * 修改日期：2019/8/15
     *
     * @param Builder $instance
     * @param string $columns
     * @throws  \Exception
     * @return bool|int
     */
    public function cacheCount(Builder $instance, $columns = '*')
    {
        return $this->cacheQuery($instance, 'count', $columns);
    }

    /**
     * 功能：获取多条记录
     * 修改日期：2019/8/15
     *
     * @param Builder $instance
     * @param array $columns
     * @throws  \Exception
     * @return bool|Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function cacheGet(Builder $instance, array $columns = ['*'])
    {
        return $this->cacheQuery($instance, 'get', $columns);
    }

    /**
     * 功能：缓存查询
     * 修改日期：2019/9/22
     *
     * @param Builder $instance
     * @param string $query
     * @param mixed ...$params
     * @throws  \Exception
     * @return bool|mixed
     */
    public function cacheQuery(Builder $instance, string $query, ...$params)
    {
        $cacheSwitch = config('system.db_cache');
        $cacheKey = self::createCacheKey([$instance->toSql(), $instance->getBindings(), $query, $params]);
        if ($cacheSwitch) {
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        if (!method_exists($instance, $query)) {
            throw new \Exception('Class ' . get_class($instance) . " does not have method $query");
        }
        $result = $instance->{$query}(...$params);
        if ($cacheSwitch) {
            try {
                Cache::set($cacheKey, $result, intval(config('system.db_cache_time')) / 60);
            } catch (InvalidArgumentException $e) {
                return $this->appendMessage($e->getMessage());
            }
        }
        return $result;
    }

    /**
     * 功能：获取分页
     * 修改日期：2019/8/15
     *
     * @param Builder $instance
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @throws  \Exception
     * @return bool|Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function cachePaginate(
        Builder $instance,
        int $perPage = null,
        array $columns = ['*'],
        string $pageName = 'page',
        $page = null
    ) {
        $page = $page ?? Paginator::resolveCurrentPage($pageName);
        return $this->cacheQuery($instance, 'paginate', $perPage, $columns, $pageName, $page);
    }
}
