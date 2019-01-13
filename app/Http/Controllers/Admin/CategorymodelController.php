<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\Admin;
use Illuminate\Http\Request;

class CategorymodelController extends Controller
{

    public function index()
    {
        $categoryModelList = CategoryModel::all();
        $categorymodelInfoPower = (new Admin())->checkPower('categorymodel', 'info');
        return view('admin.categorymodel.index', compact('categoryModelList', 'categorymodelInfoPower'));
    }

    public function info($id)
    {
        $info = CategoryModel::find($id);
        if (! $info) {
            return response()->json([
                'status' => 10001,
                'message' => '记录不存在'
            ]);
        }
        $categorymodelEditPower = (new Admin())->checkPower('categorymodel', 'edit');
        return view('admin.categorymodel.info', compact('info', 'categorymodelEditPower'));
    }

    public function edit(Request $request)
    {
        $categoryModel = CategoryModel::find($request->post('id'));
        $res = $categoryModel->fill($request->post())
            ->save();
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
