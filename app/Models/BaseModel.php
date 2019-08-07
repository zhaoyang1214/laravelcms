<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
     * @param string|array|\Closure $column            
     * @param mixed $operator            
     * @param mixed $value            
     * @param string $boolean            
     * @param bool $cache            
     * @param null|int|\DateInterval $ttl            
     * @param array $columns            
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public static function getInfo($column, $operator = null, $value = null, string $boolean = 'and', bool $cache = true, $ttl = 7200, array $columns = ['*'])
    {
        if ($cache) {
            $key = self::createCacheKey([
                (new static())->getTable(),
                static::class,
                __FUNCTION__,
                $column,
                $operator,
                $value,
                $boolean,
                $columns
            ]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $info = static::query()->where($column, $operator, $value, $boolean)->first($columns);
        Cache::set($key, $info, $ttl);
        return $info;
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
     * @return int
     */
    public static function getCount($column, $operator = null, $value = null, string $boolean = 'and', bool $cache = true, $ttl = 7200)
    {
        if ($cache) {
            $key = self::createCacheKey([
                (new static())->getTable(),
                static::class,
                __FUNCTION__,
                $column,
                $operator,
                $value,
                $boolean
            ]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $count = static::query()->where($column, $operator, $value, $boolean)->count();
        Cache::set($key, $count, $ttl);
        return $count;
    }

    /**
     * 获取多条记录数
     *
     * @param string|array|\Closure $column            
     * @param mixed $operator            
     * @param mixed $value            
     * @param string $boolean            
     * @param int $limit            
     * @param int $offset            
     * @param bool $cache            
     * @param null|int|\DateInterval $ttl            
     * @param array $columns            
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getList($column, $operator = null, $value = null, string $boolean = 'and', int $limit = null, int $offset = null, string $orderByColumn = null, string $orderBydirection = 'ASC', bool $cache = true, $ttl = 7200, array $columns = ['*'])
    {
        if ($cache) {
            $key = self::createCacheKey([
                (new static())->getTable(),
                static::class,
                __FUNCTION__,
                $column,
                $operator,
                $value,
                $boolean,
                $limit,
                $offset,
                $orderByColumn,
                $orderBydirection,
                $columns
            ]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $query = static::query()->where($column, $operator, $value, $boolean);
        if (isset($orderByColumn)) {
            $query = $query->orderBy($orderByColumn, $orderBydirection);
        }
        if (isset($limit)) {
            $query = $query->limit($limit);
        }
        if (isset($offset)) {
            $query = $query->offset($offset);
        }
        $list = $query->get($columns);
        Cache::set($key, $list, $ttl);
        return $list;
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
     * @return bool
     */
    public function getModel(string $modelName)
    {
        self::$tableName = null;
        $class = 'App\\Models\\' . ucfirst($modelName);
        if (class_exists($class)) {
            return new $class();
        }
        return false;
    }

    /**
     * 功    能：查询单条记录（带缓存）
     * 修改日期：2019/8/7
     *
     * @param \Illuminate\Database\Eloquent\Builder $instance Builder
     * @return \Illuminate\Database\Eloquent\Model|object|static|null|bool
     */
    public function cacheOne(\Illuminate\Database\Eloquent\Builder $instance)
    {
        $cacheSwitch = config('system.db_cache');
        $cacheKey = md5($instance->toSql() . serialize($instance->getBindings()));
        if ($cacheSwitch) {
            $result = Cache::get($cacheKey);
            if (!is_null($result)) {
                return unserialize($result);
            }
        }
        $result = $instance->first();
        if ($cacheSwitch) {
            try {
                Cache::set($cacheKey, $result, intval(config('system.db_cache_time')) / 60);
            } catch (\Psr\SimpleCache\InvalidArgumentException $e) {
                return $this->appendMessage($e->getMessage());
            }
        }
        return $result;
    }
}
