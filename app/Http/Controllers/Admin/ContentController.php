<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ContentData;
use App\Models\ContentPosition;
use App\Models\ContentTags;
use App\Models\Expand;
use App\Models\ExpandData;
use App\Models\Tags;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;
use App\Models\Position;
use App\Models\AdminAuth;
use App\Models\ExpandField;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\DB;
use SCWS\PSCWS4;

class ContentController extends Controller
{

    public function list(Request $request)
    {
        $position = intval($request->get('position', 0));
        $search = $request->get('search');
        
        $query = Content::query()->select(
            'content.id',
            'content.category_id',
            'content.title',
            'content.urltitle',
            'content.subtitle',
            'content.font_color',
            'content.font_bold',
            'content.keywords',
            'content.description',
            'content.update_time',
            'content.input_time',
            'content.image',
            'content.jump_url',
            'content.sequence',
            'content.tpl',
            'content.status',
            'content.copyfrom',
            'content.views',
            'content.position',
            'content.taglink',
            'category.name AS category_name',
            'category_model.content AS content_c'
        )->leftJoin('category', 'category.id', '=', 'content.category_id')
            ->leftJoin('category_model', 'category_model.id', '=', 'category.category_model_id');
        if (empty($position) && empty($search)) {
            $query = $query->where('content.status', 0);
        }
        if (! empty($position)) {
            $query = $query->leftJoin('content_position', 'content_position.content_id', '=', 'content.id')
                ->where('content_position.position_id', $position);
        }
        $adminGroupInfo = session('adminGroupInfo');
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])) {
                $query = $query->whereIn('content.id', 0);
            } else {
                $query = $query->whereIn('category.id', explode(',', $adminGroupInfo['category_ids']));
            }
        }
        if (! empty($search)) {
            $query = $query->where('content.title', 'LIKE', "%{$search}%");
        }
        $query2 = clone $query;
        $datas = $query->orderByDesc('content.update_time')->paginate(10);
        $notAuditCount = $query2->where('content.status', 0)->count();
        $categoryCount = (new Category())->getAllowCount();
        $positionList = array_column((new Position())->get()->toArray(), null, 'id');
        $admin = new Admin();
        $contentInfoPower = $admin->checkPower('content', 'info');
        $contentAuditPower = $admin->checkPower('content', 'audit');
        $contentQuickEditPower = $admin->checkPower('content', 'quickEdit');
        $contentDeletePower = $admin->checkPower('content', 'delete');
        return view('admin.content.list', compact(
            'datas',
            'position',
            'search',
            'notAuditCount',
            'categoryCount',
            'positionList',
            'contentInfoPower',
            'contentAuditPower',
            'contentQuickEditPower',
            'contentDeletePower'
        ));
    }

    public function manage()
    {
        $adminAuthInfo = AdminAuth::getInfoByConAct('content', 'manage');
        $authList = [];
        if (! empty($adminAuthInfo)) {
            $authList = AdminAuth::getAllowListFormat($adminAuthInfo->id);
        }
        $query = Category::query()
            ->select(
                'category.id',
                'category.pid',
                'category.category_model_id',
                'category.type',
                'category.name',
                'category_model.category',
                'category_model.content'
            )->leftJoin('category_model', 'category_model.id', '=', 'category.category_model_id');
        $adminGroupInfo = session('adminGroupInfo');
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])) {
                $query = $query->where('category.id', 0);
            } else {
                $query = $query->whereIn('category.id', explode(',', $adminGroupInfo['category_ids']));
            }
        }
        $categoryList = $query->orderBy('category.sequence')
            ->orderBy('category.id')
            ->get()
            ->toArray();
        foreach ($categoryList as &$v) {
            if (empty($v['content'])) {
                $v['url'] = "/admin/{$v['category']}/info/{$v['id']}";
                $v['target'] = 'main';
                $v['icon'] = '/lib/ztree/css/img/ico2.gif';
            } else {
                if ($v['type'] == 2) {
                    $v['url'] = "/admin/{$v['content']}/index/{$v['id']}";
                    $v['target'] = 'main';
                    $v['icon'] = '/lib/ztree/css/img/ico3.gif';
                } else {
                    $v['icon'] = '/lib/ztree/css/img/ico1.gif';
                }
            }
        }
        $categoryList = json_encode($categoryList, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return view('admin.content.manage', compact('categoryList', 'authList'));
    }

    public function index(Request $request, $categoryId)
    {
        $sequence = intval($request->get('sequence', 1));
        $status = intval($request->get('status', 1));
        $position = intval($request->get('position', 0));
        $search = $request->get('search');
        
        $adminGroupInfo = session('adminGroupInfo');
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])
                || !in_array($categoryId, explode(',', $adminGroupInfo['category_ids']))) {
                $categoryId = 0;
            }
        }
        
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect('errors/404');
        }
        
        $query = Content::query()->select(
            'content.id',
            'content.category_id',
            'content.title',
            'content.urltitle',
            'content.subtitle',
            'content.font_color',
            'content.font_bold',
            'content.keywords',
            'content.description',
            'content.update_time',
            'content.input_time',
            'content.image',
            'content.jump_url',
            'content.sequence',
            'content.tpl',
            'content.status',
            'content.copyfrom',
            'content.views',
            'content.position',
            'content.taglink',
            'category.name AS category_name',
            'category_model.content AS content_c'
        )->leftJoin('category', 'category.id', '=', 'content.category_id')
            ->leftJoin('category_model', 'category_model.id', '=', 'category.category_model_id');
        $query = $query->where('content.status', $status);
        if (! empty($position)) {
            $query = $query->leftJoin('content_position', 'content_position.content_id', '=', 'content.id')
                ->where('content_position.position_id', $position);
        }
        $query = $query->where('category.id', $categoryId);
        if (! empty($search)) {
            $query = $query->where('content.title', 'LIKE', "%{$search}%");
        }
        switch ($sequence) {
            case 2:
                $query = $query->orderBy('content.update_time');
                break;
            case 3:
                $query = $query->orderByDesc('content.id');
                break;
            case 4:
                break;
            case 5:
                $query = $query->orderByDesc('content.input_time');
                break;
            case 6:
                $query = $query->orderBy('content.input_time');
                break;
            case 7:
                $query = $query->orderByDesc('content.views');
                break;
            case 8:
                $query = $query->orderBy('content.views');
                break;
            case 1:
            default:
                $query = $query->orderByDesc('content.update_time');
        }
        $datas = $query->orderBy('content.id')->paginate(10);
        $positionList = array_column((new Position())->get()->toArray(), null, 'id');
        $admin = new Admin();
        $contentAddPower = $admin->checkPower('content', 'add');
        $contentInfoPower = $admin->checkPower('content', 'info');
        $contentAuditPower = $admin->checkPower('content', 'audit');
        $contentQuickEditPower = $admin->checkPower('content', 'quickEdit');
        $contentDeletePower = $admin->checkPower('content', 'delete');
        $contentMovePower = $admin->checkPower('content', 'move');
        $categoryList = (new Category())->getAllowList();
        return view('admin.content.index', compact(
            'datas',
            'sequence',
            'status',
            'position',
            'search',
            'positionList',
            'category',
            'contentAddPower',
            'contentInfoPower',
            'contentAuditPower',
            'contentQuickEditPower',
            'contentDeletePower',
            'contentMovePower',
            'categoryList'
        ));
    }

    public function add(Request $request, $categoryId = null)
    {
        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                $data = $request->post();
                unset($data['content'], $data['_token']);
                $content = new Content();
                $content = $content->add($data);
                if (! $content) {
                    return response()->json([
                        'status' => 10001,
                        'message' => '添加失败'
                    ]);
                }
                $contentId = $content->id;
                $contentData = [
                    'content_id' => $contentId,
                    'content' => htmlspecialchars($request->post('content', ''))
                ];
                $contentData = ContentData::create($contentData);
                if (! $contentData) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 10001,
                        'message' => '添加失败'
                    ]);
                }
                $category = Category::find($content->category_id);
                if (!empty($category->expand_id)) {
                    $expand = Expand::find($category->expand_id);
                    if ($expand) {
                        $expandData = new ExpandData($expand->table);
                        $res = $expandData->add($data, $expand->id);
                        if (! $res) {
                            DB::rollBack();
                            return response()->json([
                                'status' => 10001,
                                'message' => $expandData->getMessages()[0]['message'],
                            ]);
                        }
                    }
                }
                if (isset($data['position']) && !empty($data['position']) && is_array($data['position'])) {
                    $addRes = (new ContentPosition())->addByArr($data['position'], $contentId);
                    if (! $addRes) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '添加失败'
                        ]);
                    }
                }
                if (!empty($data['keywords'])) {
                    $keywords = explode(',', $data['keywords']);
                    $nowDate = date('Y-m-d H:i:s');
                    foreach ($keywords as $keyword) {
                        $tags = Tags::firstOrCreate(['name' => $keyword], [
                            'create_time' => $nowDate,
                            'update_time' => $nowDate,
                        ]);
                        ContentTags::insert([
                            'content_id' => $contentId,
                            'tags_id' => $tags->id,
                        ]);
                    }
                }
                DB::commit();
                return response()->json([
                    'status' => 10000,
                    'message' => '添加成功'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 10001,
                    'message' => '添加失败'
                ]);
            }
        }
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect('errors/404');
        }
        $admin = new Admin();
        $actionUrl = '/admin/content/add';
        $action = 'add';
        $actionName = '添加';
        $actionPower = $admin->checkPower('content', 'add');
        $contentAuditPower = $admin->checkPower('content', 'audit');
        $categoryList = (new Category())->getAllowList();
        $positionList = Position::get();
        $expandFieldList = ExpandField::where('expand_id', $category->expand_id)->get();
        $categoryModel = CategoryModel::find($category->category_model_id);
        return view('admin.content.info', compact(
            'category',
            'actionUrl',
            'action',
            'actionName',
            'actionPower',
            'contentAuditPower',
            'categoryList',
            'positionList',
            'expandFieldList',
            'categoryModel'
        ));
    }

    public function getKeywords(Request $request)
    {
        $text = $request->post('text');
        $limit = 5;
        $cws = new PSCWS4();
        $cws->set_charset('utf8');
        $cws->set_dict('../vendor/scws/pscws4/dict/dict.utf8.xdb');
        $cws->set_rule('../vendor/scws/pscws4/etc/rules.ini');
        $cws->set_ignore(true);
        $cws->set_duality(true);
        $cws->send_text($text);
        $result = $cws->get_tops($limit, 'r,v,p');
        $cws->close();
        return response()->json($result == false ? [] : $result);
    }

    public function quickEdit(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                $data = $request->post();
                unset($data['_token']);
                $content = new Content();
                $content = $content->edit($data['id'], $data);
                if (!$content) {
                    return response()->json([
                        'status' => 10001,
                        'message' => $content->getMessages()[0]['message'],
                    ]);
                }
                $contentId = $content->id;
                $position = isset($data['position']) && is_array($data['position']) ? $data['position'] : [];
                $contentPostionList = ContentPosition::where('content_id', $contentId)->get()->toArray();
                $oldPostionIds = array_column($contentPostionList, 'position_id');
                $addData = array_values(array_diff($position, $oldPostionIds));
                $delData = array_values(array_diff($oldPostionIds, $position));
                if (!empty($addData)) {
                    $addRes = (new ContentPosition())->addByArr($addData, $contentId);
                    if (! $addRes) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '添加失败'
                        ]);
                    }
                }
                if (!empty($delData)) {
                    $delRes = ContentPosition::where('content_id', $contentId)
                        ->whereIn('position_id', $delData)
                        ->delete();
                    if (! $delRes) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '删除推荐位失败'
                        ]);
                    }
                }
                $keywords = empty($data['keywords']) ? [] : explode(',', $data['keywords']);
                $nowDate = date('Y-m-d H:i:s');
                $tagsIds = [];
                foreach ($keywords as $keyword) {
                    $tags = Tags::firstOrCreate(['name' => $keyword], [
                        'create_time' => $nowDate,
                        'update_time' => $nowDate,
                    ]);
                    if (!$tags) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '添加失败'
                        ]);
                    }
                    $tagsIds[] = $tags->id;
                }
                $contentTagsList = ContentTags::where('content_id', $contentId)->get()->toArray();
                $oldTagsIds = array_column($contentTagsList, 'tags_id');
                $tagsIntersect = array_values(array_intersect($tagsIds, $oldTagsIds));
                $addTagsData = array_values(array_diff($tagsIds, $tagsIntersect));
                $delTagsData = array_values(array_diff($oldTagsIds, $tagsIntersect));
                if (!empty($addTagsData)) {
                    $res = (new ContentTags())->addByArr($addTagsData, $contentId);
                    if (!$res) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '添加失败'
                        ]);
                    }
                }
                if (!empty($delTagsData)) {
                    $delRes = ContentTags::where('content_id', $contentId)
                        ->whereIn('tags_id', $delTagsData)
                        ->delete();
                    if (! $delRes) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 10001,
                            'message' => '删除关键词失败'
                        ]);
                    }
                }
                DB::commit();
                return response()->json([
                    'status' => 10000,
                    'message' => '添加成功'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 10001,
                    'message' => '修改失败'
                ]);
            }
        }
        $info = Content::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $positionList = Position::get();
        $contentAuditPower = (new Admin())->checkPower('content', 'audit');
        $actionUrl = '/admin/content/quickEdit';
        $actionName = '添加';
        return view('admin.content.quickEdit', compact(
            'info',
            'positionList',
            'contentAuditPower',
            'actionUrl',
            'actionName'
        ));
    }
}
