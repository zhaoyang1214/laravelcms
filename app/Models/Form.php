<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Form extends BaseModel
{

    protected $table = 'form';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'name',
        'no',
        'table',
        'sequence',
        'sort',
        'display',
        'page',
        'tpl',
        'where',
        'return_type',
        'return_msg',
        'return_url',
        'is_captcha'
    ];

    public static function getAllowList(int $limit = null, int $offset = null)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 1)) {
            if (empty($adminGroupInfo['form_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['form_ids']));
        }
        $query->orderBy('sequence');
        if (! is_null($limit)) {
            $query->limit($limit);
        }
        if (! is_null($offset)) {
            $query->offset($offset);
        }
        return $query->get()->toArray();
    }

    public static function getPaginator(int $perPage)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 1)) {
            if (empty($adminGroupInfo['form_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['form_ids']));
        }
        return $query->orderBy('sequence')->paginate($perPage);
    }

    public function add(array $data)
    {
        $data['no'] = md5(md5($data['name'] . microtime(true)));
        $table = $this->table . '_data_' . $data['table'];
        if (Schema::hasTable($table)) {
            return $this->appendMessage('该表已存在');
        }
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
        });
        return self::create($data);
    }

    public function getOne(int $id)
    {
        $adminGroupInfo = session('adminGroupInfo');
        if (! ($adminGroupInfo['keep'] & 1) && ! in_array($id, $adminGroupInfo['form_id_arr'])) {
            return $this->appendMessage('该表单不存在');
        }
        return self::find($id);
    }

    public function deleteById(int $id)
    {
        $info = $this->getOne($id);
        if (! $info) {
            return $this->appendMessage('该表单不存在');
        }
        $data = $info->toArray();
        $table = $this->table . '_data_' . $data['table'];
        $res = $info->delete();
        Schema::drop($table);
        return $res;
    }
}
