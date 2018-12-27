<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BaseModel extends Model
{

    /**
     * 错误信息
     */
    protected $errorMessages = [];

    /**
     * 添加错误信息
     *
     * @param string $message            
     * @param int $code            
     * @return $this
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
     * @param array $tags            
     * @param array $columns            
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public static function getInfo($column, $operator = null, $value = null, string $boolean = 'and', bool $cache = true, $ttl = 7200, array $tags = [], array $columns = ['*'])
    {
        if ($cache) {
            $key = self::createCacheKey([
                (new static())->getTable(),
                static::class,
                __FUNCTION__,
                $column,
                $operator,
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
}
