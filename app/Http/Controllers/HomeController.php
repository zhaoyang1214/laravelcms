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
}
