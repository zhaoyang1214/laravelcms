<?php
namespace App\Models;

/**
 * App\Models\Fragment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $sign 标识
 * @property string $title 描述
 * @property string $content 内容
 * @property int $rm_html 去除html标签，0：否，1：去除最外层p标签；2:去除所有html标签
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereRmHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fragment whereUpdateTime($value)
 */
class Fragment extends BaseModel
{

    protected $table = 'fragment';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'sign',
        'title',
        'content',
        'rm_html'
    ];

    public function add(array $data)
    {
        switch ($data['rm_html']) {
            case 1:
                $data['content'] = preg_replace([
                    '/^<p.*>/iU',
                    '/<\/p>$/iU'
                ], '', $data['content']);
                break;
            case 2:
                $data['content'] = strip_tags($data['content']);
                break;
        }
        $data['content'] = htmlspecialchars($data['content']);
        return self::create($data);
    }

    public function edit(array $data)
    {
        $info = self::find(intval($data['id'] ?? 0));
        if (! $info) {
            return $this->appendMessage('数据不存在');
        }
        switch ($data['rm_html']) {
            case 1:
                $data['content'] = preg_replace([
                    '/^<p.*>/iU',
                    '/<\/p>$/iU'
                ], '', $data['content']);
                break;
            case 2:
                $data['content'] = strip_tags($data['content']);
                break;
        }
        $data['content'] = htmlspecialchars($data['content']);
        return $info->fill($data)->save();
    }
}
