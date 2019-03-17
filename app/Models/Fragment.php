<?php
namespace App\Models;

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
