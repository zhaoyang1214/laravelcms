<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryModel;
use App\Models\Admin;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $datas = (new Category())->getAllowList();
        $categoryModelList = CategoryModel::all()->toArray();
        $categoryModelList = array_column($categoryModelList, null, 'id');
        $categorySequencePower = (new Admin())->checkPower('category', 'sequence');
        $list = (new CategoryModel())->getAllowCategoryList();
        return view('admin.category.index', compact('datas', 'categoryModelList', 'categorySequencePower', 'list'));
    }

    public function sequence(Request $request)
    {
        $id = intval($request->post('id', '0'));
        $sequence = intval($request->post('sequence', '0'));
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json([
                'status' => 10001,
                'message' => '记录不存在'
            ]);
        }
        $res = $category->fill([
            'sequence' => $sequence
        ])->save();
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
}
