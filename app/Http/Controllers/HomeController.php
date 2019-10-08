<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function media(string $title = '', string $keywords = '', string $description = '')
    {
        $system = config('system');
        $title .= (empty($title) ? '' : ' - ') . $system['sitename'];
        if (empty($keywords)) {
            $keywords = $system['keywords'];
        }
        if (empty($description)) {
            $description = $system['description'];
        }
        return [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ];
    }

    /**
     * 功能：弹出消息提示
     * 修改日期：2019/10/4
     *
     * @param string $message
     * @param string|bool|null $jumpUrl
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function alert(string $message, $jumpUrl = null)
    {
        if (is_null($jumpUrl)) {
            return '<script>alert("' . $message .'");window.history.go(-1);</script>';
        } elseif ($jumpUrl === false) {
            return '<script>alert("' . $message .'");</script>';
        } else {
            return '<script>alert("' . $message .'");window.location.href ="' . $jumpUrl . '"</script>';
        }
    }
}
