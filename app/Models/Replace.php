<?php
namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Replace
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $key 关键字
 * @property string $content 要替换的内容
 * @property int $num 替换次数，0：不限制
 * @property int $status 状态，0：禁用，1：启用
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereUpdateTime($value)
 */
class Replace extends BaseModel
{

    protected $table = 'replace';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'key',
        'content',
        'num',
        'status'
    ];

    /**
     * 功能：替换内容
     * 修改日期：2019/8/18
     *
     * @param string $content
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @return mixed|string
     */
    public function replaceContent(string $content)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([__class__, __method__, $content]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = self::getListCache('status', 1);
        foreach ($list as $replace) {
            $count = $replace->num > 0 ? $replace->num : null;
            $content = preg_replace("/{$replace->key}/", $replace->content, $content, $count);
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $content;
    }
}
