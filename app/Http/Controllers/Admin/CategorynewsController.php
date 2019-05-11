<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Expand;
use App\Models\Content;
use App\Models\ContentData;

class CategorynewsController extends Controller
{

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $category = new Category();
            $data = $request->post();
            $data['category_model_id'] = 1;
            $res = $category->add($data);
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
        $category = new Category();
        $categoryList = $category->getAllowList();
        $expandList = Expand::get();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/categorynews/add';
        $action = 'add';
        return view('admin.categorynews.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'categoryList', 'expandList'));
    }

    public function info($id)
    {
        $info = Category::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $category = new Category();
        $categoryList = $category->getAllowList();
        $expandList = Expand::get();
        $actionPower = true;
        $actionName = '修改';
        $actionUrl = '/admin/categorynews/edit';
        $action = 'edit';
        $categorynewsEditPower = (new Admin())->checkPower('categorynews', 'edit');
        return view('admin.categorynews.info', compact('info', 'actionPower', 'actionName', 'actionUrl', 'action', 'categoryList', 'expandList'));
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
        $content = Content::where('category_id', $id)->get();
        if (! empty($content)) {
            $contentIdArr = array_column($content->toArray(), 'id');
            ContentData::whereIn('content_id', $contentIdArr)->delete();
            Content::where('category_id', $id)->delete();
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
