<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\TagsGroup;
use App\Models\ContentTags;

class TagsController extends Controller
{

    public function index(Request $request)
    {
        $sequence = $request->get('sequence', 0);
        $tagsGroupId = $request->get('tags_group_id', '-1');
        $name = $request->get('name', '');
        $query = Tags::query()->select('tags.id', 'tags.name', 'tags.click', 'tags_group.name as tags_group_name')->leftJoin('tags_group', 'tags.tags_group_id', '=', 'tags_group.id');
        if ($tagsGroupId != '-1') {
            $query = $query->where('tags_group_id', abs($tagsGroupId));
        }
        if ($name != '') {
            $query = $query->where('tags.name', 'like', "%{$name}%");
        }
        switch ($sequence) {
            case 1:
                $query = $query->orderByDesc('click');
                break;
            case 2:
                $query = $query->orderBy('click');
                break;
            default:
                $query = $query->orderByDesc('tags.id');
        }
        $datas = $query->paginate(10);
        $tagsGroupList = TagsGroup::get();
        $admin = new Admin();
        $tagsGroupingPower = $admin->checkPower('tags', 'grouping');
        $tagsDeletePower = $admin->checkPower('tags', 'delete');
        $tagsgroupIndexPower = $admin->checkPower('tagsgroup', 'index');
        $tagsgroupAddPower = $admin->checkPower('tagsgroup', 'add');
        return view('admin.tags.index', compact('datas', 'sequence', 'tagsGroupId', 'name', 'tagsGroupList', 'tagsGroupingPower', 'tagsDeletePower', 'tagsgroupIndexPower', 'tagsgroupAddPower'));
    }

    public function delete(Request $request)
    {
        $ids = $request->post('ids', '');
        $idArr = explode(',', $ids);
        ContentTags::whereIn('tags_id', $idArr)->delete();
        $res = Tags::whereKey($idArr)->delete();
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '删除成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => '删除失败'
        ]);
    }

    public function grouping(Request $request)
    {
        $ids = $request->post('ids', '');
        $idArr = explode(',', $ids);
        $tagsGroupId = $request->post('tags_group_id', 0);
        $res = Tags::whereKey($idArr)->update([
            'tags_group_id' => $tagsGroupId
        ]);
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '分组成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => '分组失败'
        ]);
    }
}
