<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Upload;

class UeditorController extends Controller
{

    public function __construct()
    {
        $systemConfig = config('system');
        $fileSize = $systemConfig['file_size'] * 1024 * 1024;
        $imageAllowFiles = empty($systemConfig['image_type']) ? [] : explode(',', str_replace(',', ',.', '.' . $systemConfig['image_type']));
        $videoAllowFiles = empty($systemConfig['video_type']) ? [] : explode(',', str_replace(',', ',.', '.' . $systemConfig['video_type']));
        $fileAllowFiles = empty($systemConfig['file_type']) ? [] : explode(',', str_replace(',', ',.', '.' . $systemConfig['file_type']));
        $dataPath = date('Y-m/d/');
        
        $this->ueditorConfig = [
            // 上传图片配置项
            'imageActionName' => 'uploadimage', // 执行上传图片的action名称
            'imageFieldName' => 'upfile', // 提交的图片表单名称
            'imageMaxSize' => $fileSize, // 上传大小限制，单位B
            'imageAllowFiles' => $imageAllowFiles, // ['.png', '.jpg', '.jpeg', '.gif', '.bmp'], // 上传图片格式显示
            'imageCompressEnable' => true, // 是否压缩图片,默认是true
            'imageCompressBorder' => 1600, // 图片压缩最长边限制
            'imageInsertAlign' => 'none', // 插入的图片浮动方式
            'imageUrlPrefix' => '', // 图片访问路径前缀
            'imagePathFormat' => './uploads/images/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'fileNumLimit' => intval($systemConfig['file_num']), // 允许批量上传数量
                                                                 
            // 涂鸦图片上传配置项
            'scrawlActionName' => 'uploadscrawl', // 执行上传涂鸦的action名称
            'scrawlFieldName' => 'upfile', // 提交的图片表单名称
            'scrawlPathFormat' => './uploads/scrawls/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'scrawlMaxSize' => $fileSize, // 上传大小限制，单位B
            'scrawlUrlPrefix' => '', // 图片访问路径前缀
            'scrawlInsertAlign' => 'none',
            
            // 截图工具上传
            'snapscreenActionName' => 'uploadimage', // 执行上传截图的action名称
            'snapscreenPathFormat' => './uploads/snapscreens/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'snapscreenUrlPrefix' => '', // 图片访问路径前缀
            'snapscreenInsertAlign' => 'none', // 插入的图片浮动方式
                                               
            // 抓取远程图片配置
            'catcherLocalDomain' => [
                '127.0.0.1',
                'localhost',
                'img.baidu.com'
            ],
            'catcherActionName' => 'catchimage', // 执行抓取远程图片的action名称
            'catcherFieldName' => 'upfile', // 提交的图片列表表单名称
            'catcherPathFormat' => './uploads/catchers/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'catcherUrlPrefix' => '', // 图片访问路径前缀
            'catcherMaxSize' => $fileSize, // 上传大小限制，单位B
            'catcherAllowFiles' => $imageAllowFiles, // 抓取图片格式显示
                                                     
            // 上传视频配置
            'videoActionName' => 'uploadvideo', // 执行上传视频的action名称
            'videoFieldName' => 'upfile', // 提交的视频表单名称
            'videoPathFormat' => './uploads/videos/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'videoUrlPrefix' => '', // 视频访问路径前缀
            'videoMaxSize' => $fileSize, // 上传大小限制，单位B，默认100MB
            'videoAllowFiles' => $videoAllowFiles, // 上传视频格式显示
                                                   
            // 上传文件配置
            'fileActionName' => 'uploadfile', // controller里,执行上传视频的action名称
            'fileFieldName' => 'upfile', // 提交的文件表单名称
            'filePathFormat' => './uploads/files/' . $dataPath, // 上传保存路径,可以自定义保存路径和文件名格式
            'fileUrlPrefix' => '', // 文件访问路径前缀
            'fileMaxSize' => $fileSize, // 上传大小限制，单位B，默认50MB
            'fileAllowFiles' => $fileAllowFiles, // 上传文件格式显示
                                                 
            // 列出指定目录下的图片
            'imageManagerActionName' => 'listimage', // 执行图片管理的action名称
            'imageManagerListPath' => './uploads/images/', // 指定要列出图片的目录
            'imageManagerListSize' => 20, // 每次列出文件数量
            'imageManagerUrlPrefix' => '', // 图片访问路径前缀
            'imageManagerInsertAlign' => 'none', // 插入的图片浮动方式
            'imageManagerAllowFiles' => $imageAllowFiles, // 列出的文件类型
                                                          
            // 列出指定目录下的文件
            'fileManagerActionName' => 'listfile', // 执行文件管理的action名称
            'fileManagerListPath' => './uploads/files/', // 指定要列出文件的目录
            'fileManagerUrlPrefix' => '', // 文件访问路径前缀
            'fileManagerListSize' => 20, // 每次列出文件数量
            'fileManagerAllowFiles' => $fileAllowFiles // 列出的文件类型
        ];
    }

    public function index(Request $request)
    {
        set_time_limit(3600);
        switch ($request->get('action')) {
            case 'config':
                $response = $this->ueditorConfig;
                break;
            case 'uploadimage':
                $config = [
                    'allowFiles' => $this->ueditorConfig['imageAllowFiles'],
                    'maxSize' => $this->ueditorConfig['imageMaxSize'],
                    'pathFormat' => $this->ueditorConfig['imagePathFormat'],
                    'origin' => intval($request->get('origin', - 1)),
                    'watermark_switch' => intval($request->post('watermark_switch', 0)),
                    'watermark_place' => intval($request->post('watermark_place', 0)),
                    'thumbnail_switch' => intval($request->post('thumbnail_switch', 0)),
                    'thumbnail_maxwidth' => intval($request->post('thumbnail_maxwidth', 210)),
                    'thumbnail_maxheight' => intval($request->post('thumbnail_maxheight', 110)),
                    'thumbnail_cutout' => intval($request->post('thumbnail_cutout', 1))
                ];
                $response = $this->uploadfile($config);
                break;
            case 'uploadvideo':
                $config = [
                    'allowFiles' => $this->ueditorConfig['videoAllowFiles'],
                    'maxSize' => $this->ueditorConfig['videoMaxSize'],
                    'pathFormat' => $this->ueditorConfig['videoPathFormat'],
                    'origin' => intval($request->get('origin', - 1))
                ];
                $response = $this->uploadfile($config);
                break;
            case 'uploadfile':
                $config = [
                    'allowFiles' => $this->ueditorConfig['fileAllowFiles'],
                    'maxSize' => $this->ueditorConfig['fileMaxSize'],
                    'pathFormat' => $this->ueditorConfig['filePathFormat'],
                    'origin' => intval($request->get('origin', - 1))
                ];
                $response = $this->uploadfile($config);
                break;
            case 'uploadscrawl':
                $config = [
                    'allowFiles' => $this->ueditorConfig['imageAllowFiles'],
                    'maxSize' => $this->ueditorConfig['scrawlMaxSize'],
                    'pathFormat' => $this->ueditorConfig['scrawlPathFormat'],
                    'base64Data' => $request->post($this->ueditorConfig['scrawlFieldName']),
                    'watermark_switch' => intval($request->post('watermark_switch', 0)),
                    'watermark_place' => intval($request->post('watermark_place', 0)),
                    'origin' => intval($request->get('origin', - 1))
                ];
                $response = $this->uploadBase64($config);
                break;
            case 'listimage':
                $config = [
                    'allowFiles' => $this->ueditorConfig['imageManagerAllowFiles'],
                    'maxSize' => $this->ueditorConfig['imageMaxSize'],
                    'listPath' => $this->ueditorConfig['imageManagerListPath'],
                    'size' => $this->ueditorConfig['imageManagerListSize'],
                    'start' => intval($request->get('start', 0))
                ];
                $response = $this->listfile($config);
                break;
            case 'listfile':
                $config = [
                    'allowFiles' => $this->ueditorConfig['fileManagerAllowFiles'],
                    'maxSize' => $this->ueditorConfig['fileMaxSize'],
                    'listPath' => $this->ueditorConfig['fileManagerListPath'],
                    'size' => $this->ueditorConfig['fileManagerListSize'],
                    'start' => intval($request->get('start', 0))
                ];
                $response = $this->listfile($config);
                break;
            default:
                $response = [
                    'state' => '请求地址出错'
                ];
        }
        return response()->json($response);
    }

    public function getUpfileHtml(Request $request)
    {
        $data = [];
        switch ($request->query('type')) {
            case 'file':
                $renderView = 'admin/ueditor/file';
                break;
            case 'image':
                $renderView = 'admin/ueditor/image';
                $data['fieldName'] = $this->ueditorConfig['scrawlFieldName'];
                break;
            case 'images':
                $renderView = 'admin/ueditor/images';
                break;
            default:
                return;
        }
        $data['origin'] = $request->query('origin', - 1);
        $data['id'] = $request->query('id');
        return view($renderView, $data);
    }

    /**
     * base64编码图片上传
     */
    private function uploadBase64(array $config)
    {
        $base64Data = $config['base64Data'];
        if (empty($base64Data)) {
            $state = '未上传图片';
            goto error_response;
        }
        $imagedata = base64_decode($base64Data);
        $fileSize = strlen($imagedata);
        if ($fileSize > $config['maxSize']) {
            $state = '图片大小超出限制';
            goto error_response;
        }
        try {
            $img = Image::make($base64Data);
            list ($width, $height, $imagetype, $attr) = getimagesizefromstring($imagedata);
            $extension = image_type_to_extension($imagetype);
            if (! in_array($extension, $config['allowFiles'])) {
                $state = '图片类型错误';
                goto error_response;
            }
            if ($config['watermark_switch']) {
                $watermarkImageFile = '.' . config('system.watermark_image');
                if (! is_file($watermarkImageFile)) {
                    $state = '水印图片不存在';
                    goto error_response;
                }
                re_watermark_place:
                switch ($config['watermark_place']) {
                    case 1:
                        $position = 'top-left';
                        break;
                    case 2:
                        $position = 'top';
                        break;
                    case 3:
                        $position = 'top-right';
                        break;
                    case 4:
                        $position = 'left';
                        break;
                    case 5:
                        $position = 'center';
                        break;
                    case 6:
                        $position = 'right';
                        break;
                    case 7:
                        $position = 'bottom-left';
                        break;
                    case 8:
                        $position = 'bottom';
                        break;
                    case 9:
                        $position = 'bottom-right';
                        break;
                    default:
                        $config['watermark_place'] = mt_rand(1, 9);
                        goto re_watermark_place;
                }
                $img->insert($watermarkImageFile, $position);
            }
            $fileName = md5(microtime(true) . mt_rand(1000, 9999));
            if (! is_dir($config['pathFormat'])) {
                if (! mkdir($config['pathFormat'], 0777, true)) {
                    $state = '创建目录失败:' . $config['pathFormat'];
                    goto error_response;
                }
            }
            $filePath = $config['pathFormat'] . $fileName . $extension;
            $img->save($filePath);
        } catch (\Exception $e) {
            $state = $e->getMessage();
            goto error_response;
        }
        $filePath = ltrim($filePath, '.');
        Upload::create([
            'file' => $filePath,
            'folder' => $config['pathFormat'],
            'title' => $fileName,
            'ext' => ltrim($extension, '.'),
            'size' => $fileSize,
            'type' => $img->mime(),
            'time' => date('Y-m-d H:i:s'),
            'module' => $config['origin']
        ]);
        return [
            'size' => $fileSize,
            'state' => 'SUCCESS',
            'title' => $fileName,
            'type' => $extension,
            'url' => $filePath
        ];
        $state = '上传失败';
        error_response:
        return [
            'state' => $state
        ];
    }
}
