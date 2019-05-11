<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryJump;

class CategoryjumpController extends Controller
{

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $category = new Category();
            $data = $request->post();
            $data['category_model_id'] = 3;
            $category = $category->add($data);
            if (! $category) {
                return response()->json([
                    'status' => 10001,
                    'message' => '添加失败'
                ]);
            }
            $categoryJumpData = [
                'category_id' => $category->id,
                'url' => $request->post('url', '')
            ];
            $res = (new CategoryJump())->create($categoryJumpData);
            if (! $res) {
                $category->delete();
                return response()->json([
                    'status' => 10001,
                    'message' => '添加失败'
                ]);
            }
            return response()->json([
                'status' => 10000,
                'message' => '添加成功'
            ]);
        }
        $category = new Category();
        $categoryList = $category->getAllowList();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/categoryjump/add';
        $action = 'add';
        return view('admin.categoryjump.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'categoryList'));
    }

    public function info($id)
    {
        $info = Category::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $category = new Category();
        $categoryList = $category->getAllowList();
        $categoryJump = CategoryJump::where('category_id', $info->id)->first();
        $actionPower = true;
        $actionName = '修改';
        $actionUrl = '/admin/categoryjump/edit';
        $action = 'edit';
        $categoryjumpEditPower = (new Admin())->checkPower('categoryjump', 'edit');
        return view('admin.categoryjump.info', compact('info', 'actionPower', 'actionName', 'actionUrl', 'action', 'categoryList', 'categoryJump'));
    }

    public function edit(Request $request)
    {
        $category = new Category();
        $res = $category->edit($request->post());
        if (! $res) {
            return response()->json([
                'status' => 10001,
                'message' => '修改失败'
            ]);
        }
        $categoryId = $request->post('id');
        $categoryJumpData = [
            'category_id' => $categoryId,
            'url' => $request->post('url', '')
        ];
        $categoryJump = new CategoryJump();
        $categoryJumpInfo = $categoryJump::where('category_id', $categoryId)->first();
        if ($categoryJumpInfo) {
            $res = $categoryJumpInfo->fill($categoryJumpData)->save();
        } else {
            $res = $categoryJump->create($categoryJumpData);
        }
        if (! $res) {
            return response()->json([
                'status' => 10001,
                'message' => '修改失败'
            ]);
        }
        return response()->json([
            'status' => 10000,
            'message' => '修改成功'
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id', 0);
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json([
                'status' => 10001,
                'message' => '该栏目不存在'
            ]);
        }
        $categoryJump = CategoryJump::where('category_id', $id)->first();
        if ($categoryJump) {
            $res = $categoryJump->delete();
            if (! $res) {
                return response()->json([
                    'status' => 10001,
                    'message' => '删除失败'
                ]);
            }
        }
        $res = $category->delete();
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
