<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryPage;

class CategorypageController extends Controller
{

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $category = new Category();
            $data = $request->post();
            $data['category_model_id'] = 2;
            unset($data['content']);
            $category = $category->add($data);
            if (! $category) {
                return response()->json([
                    'status' => 10001,
                    'message' => '添加失败'
                ]);
            }
            $categoryPageData = [
                'category_id' => $category->id,
                'content' => htmlspecialchars($request->post('content', ''))
            ];
            $res = (new CategoryPage())->create($categoryPageData);
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
        $actionUrl = '/admin/categorypage/add';
        $action = 'add';
        return view('admin.categorypage.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'categoryList'));
    }

    public function info($id)
    {
        $info = Category::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $category = new Category();
        $categoryList = $category->getAllowList();
        $categoryPage = CategoryPage::where('category_id', $info->id)->first();
        $actionPower = true;
        $actionName = '修改';
        $actionUrl = '/admin/categorypage/edit';
        $action = 'edit';
        $categorypageEditPower = (new Admin())->checkPower('categorypage', 'edit');
        return view('admin.categorypage.info', compact('info', 'actionPower', 'actionName', 'actionUrl', 'action', 'categoryList', 'categoryPage'));
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
        $categoryPageData = [
            'category_id' => $categoryId,
            'content' => htmlspecialchars($request->post('content', ''))
        ];
        $categoryPage = new CategoryPage();
        $categoryPageInfo = $categoryPage::where('category_id', $categoryId)->first();
        if ($categoryPageInfo) {
            $res = $categoryPageInfo->fill($categoryPageData)->save();
        } else {
            $res = $categoryPage->create($categoryPageData);
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
        $categoryPage = CategoryPage::where('category_id', $id)->first();
        if ($categoryPage) {
            $res = $categoryPage->delete();
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
