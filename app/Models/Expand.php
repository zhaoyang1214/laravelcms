<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Expand extends BaseModel
{

    protected $table = 'expand';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'name',
        'table',
        'sequence'
    ];

    public function add(array $data)
    {
        $table = $this->table . '_data_' . $data['table'];
        if (Schema::hasTable($table)) {
            return $this->appendMessage('该模型已存在');
        }
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
        });
        return self::create($data);
    }

    public function deleteById(int $id)
    {
        $info = self::find($id);
        if (! $info) {
            return $this->appendMessage('该模型不存在');
        }
        $categoryCount = Category::where('expand_id', $id)->count();
        if ($categoryCount > 0) {
            return $this->appendMessage('该模型已被栏目使用，不允许删除');
        }
        $data = $info->toArray();
        $table = $this->table . '_data_' . $data['table'];
        $res = $info->delete();
        Schema::drop($table);
        return $res;
    }
}
