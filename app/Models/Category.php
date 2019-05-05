<?php
namespace App\Models;

use Overtrue\Pinyin\Pinyin;

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
        $data['category_model_id'] = 1;
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
        $data['keywords'] = str_replace('，', ',', $data['keywords']);
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
        $data['keywords'] = str_replace('，', ',', $data['keywords']);
        return $category->fill($data)->save();
    }
}
