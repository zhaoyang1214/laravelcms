<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagsgroup;
use App\Models\Admin;
use Illuminate\Http\Request;

class TagsgroupController extends Controller
{

    public function index()
    {
        $datas = Tagsgroup::paginate(10);
        $admin = new Admin();
        $tagsIndexPower = $admin->checkPower('tags', 'index');
        $tagsgroupAddPower = $admin->checkPower('tagsgroup', 'add');
        $tagsgroupInfoPower = $admin->checkPower('tagsgroup', 'info');
        $tagsgroupDeletePower = $admin->checkPower('tagsgroup', 'delete');
        return view('admin.tagsgroup.index', compact('datas', 'tagsIndexPower', 'tagsgroupAddPower', 'tagsgroupInfoPower', 'tagsgroupDeletePower'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Tagsgroup::create($request->post());
            if ($res) {
                return response()->json([
                    'status' => 10000,
                    'message' => '添加成功'
                ]);
            }
            return response()->json([
                'status' => 10001,
                'message' => '添加失败'
            ]);
        }
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/tagsgroup/add';
        $action = 'add';
        return view('admin.tagsgroup.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = Tagsgroup::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('tagsgroup', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/tagsgroup/edit';
        $action = 'edit';
        return view('admin.tagsgroup.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(Request $request)
    {
        $tagsgroup = Tagsgroup::find($request->post('id', 0));
        if (! $tagsgroup) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $tagsgroup->fill($request->post())
            ->save();
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '修改成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => '修改失败'
        ]);
    }

    public function delete(Request $request)
    {
        $tagsgroup = Tagsgroup::find($request->post('id', 0));
        if (! $tagsgroup) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $tagsgroup->delete();
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
}
