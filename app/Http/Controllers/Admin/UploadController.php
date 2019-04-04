<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use App\Models\Admin;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public function index(Request $request)
    {
        $ext = intval($request->get('ext', 0));
        $module = intval($request->get('module', 0));
        $title = $request->get('title', '');
        $imageExt = [
            'png',
            'jpg',
            'jpeg',
            'gif',
            'bmp'
        ];
        $videoExt = [
            'flv',
            'swf',
            'avi',
            'rm',
            'rmvb',
            'mpeg',
            'mpg',
            'ogg',
            'ogv',
            'mov',
            'wmv',
            'mp4',
            'webm',
            'mp3',
            'wav',
            'mid'
        ];
        $documentExt = [
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pptx',
            'pdf',
            'txt',
            'md',
            'xml'
        ];
        $zipExt = [
            'rar',
            'zip',
            'tar',
            'gz',
            '7z',
            'bz2',
            'cab',
            'iso'
        ];
        $query = Upload::query();
        switch ($ext) {
            case 1:
                $query = $query->whereIn('ext', $imageExt);
                break;
            case 2:
                $query = $query->whereIn('ext', $videoExt);
                break;
            case 3:
                $query = $query->whereIn('ext', $documentExt);
                break;
            case 4:
                $query = $query->whereIn('ext', $zipExt);
                break;
            case 5:
                $query = $query->whereNotIn('ext', array_merge($imageExt, $videoExt, $documentExt, $zipExt));
                break;
        }
        if (! empty($module)) {
            $query = $query->where('module', $module);
        }
        if (! empty($title)) {
            $query = $query->where('title', 'like', "%{$title}%");
        }
        $datas = $query->paginate(10);
        $modules = (new Upload())->getModule();
        $admin = new Admin();
        $uploadDeletePower = $admin->checkPower('upload', 'delete');
        return view('admin.upload.index', compact('datas', 'modules', 'ext', 'module', 'title', 'uploadDeletePower'));
    }

    public function delete(Request $request)
    {
        $upload = Upload::find($request->post('id', 0));
        if (! $upload) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $filename = '.' . $upload->file;
        $res = $upload->delete();
        if ($res) {
            if (is_file($filename)) {
                @unlink($filename);
            }
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
