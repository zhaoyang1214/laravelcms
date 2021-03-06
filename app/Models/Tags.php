<?php
namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Tags
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $tags_group_id tags_group表id
 * @property string $name 标签名
 * @property int $click 点击次数
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereTagsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereUpdateTime($value)
 */
class Tags extends BaseModel
{

    protected $table = 'tags';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'tags_group_id',
        'name',
        'click'
    ];

    public function getAllByContentId(int $contentId)
    {
        $query = static::from('content_tags as a')
            ->leftJoin('tags as b', 'a.tags_id', 'b.id')
            ->select(['b.id', 'b.tags_group_id', 'b.name', 'b.click'])
            ->where('a.content_id', $contentId);
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$query->toSql(), $query->getBindings(), 'getAllByCategoryContentId']);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $query->get();
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $list, $ttl);
        }
        return $list;
    }

    public function tagLink(string $content, int $contentId)
    {
        $cacheSwitch = (bool)config('system.db_cache');
        if ($cacheSwitch) {
            $key = self::createCacheKey([$content, $contentId, __FUNCTION__]);
            if (Cache::has($key)) {
                return Cache::get($key);
            }
        }
        $list = $this->getAllByContentId($contentId);
        if (!empty($list)) {
            $tags = array_column($list->toArray(), 'name');
            $sorts = array_map(function ($value) {
                return mb_strlen($value, 'UTF-8');
            }, $tags);
            array_multisort($sorts, SORT_DESC, SORT_NUMERIC, $tags);
            $content = preg_replace('/(' . implode('|', $tags) . ')/', '<a href="/tags/$1">$1</a>', $content);
        }
        if ($cacheSwitch) {
            $ttl = intval(config('system.db_cache_time')) / 60;
            Cache::set($key, $content, $ttl);
        }
        return $content;
    }

    /**
     * 功能：根据tag name查询内容
     * 修改日期：2019/9/28
     *
     * @param string $tag
     * @param int $listRows
     * @throws  \Exception
     * @return bool|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getListByTagName(string $tag, int $listRows)
    {
        $query = self::from('tags as a')
            ->leftJoin('content_tags as b', 'a.id', 'b.tags_id')
            ->join('content as c', 'b.content_id', 'c.id')
            ->leftJoin('category as d', 'c.category_id', 'd.id');
        $columns = [
            'c.*',
            'd.name as category_name',
            'd.subname as category_subname',
            'd.category_model_id',
            'a.name as tag_name'
        ];
        $query->select($columns)
            ->where('a.name', $tag)
            ->where('c.status', 1)
            ->orderByDesc('c.update_time')
            ->orderBy('c.id');
        return self::cachePaginate($query, $listRows);
    }
}
