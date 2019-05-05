<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryModel;
use App\Models\Admin;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $datas = (new Category())->getAllowList();
        $categoryModelList = CategoryModel::all()->toArray();
        $categoryModelList = array_column($categoryModelList, null, 'id');
        $categorySequencePower = (new Admin())->checkPower('category', 'sequence');
        $list = (new CategoryModel())->getAllowCategoryList();
        return view('admin.category.index', compact('datas', 'categoryModelList', 'categorySequencePower', 'list'));
    }
}
