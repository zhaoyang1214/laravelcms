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
}
