<?php

/**
 * Copyright (c) 2019,1134856531@qq.com
 * 摘    要：
 * 作    者：赵阳
 * 修改日期：2019/9/28
 */


namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\FormData;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Facades\Cache;

class FormController extends HomeController
{

    /**
     * 功能：
     * 修改日期：2019/9/29
     *
     * @param string $no
     * @param Request $request
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(string $no, Request $request)
    {
        $url = $request->getUri();
        $systemConfig = config('system');
        $viewCacheKey = 'view:' . $url;
        if ($systemConfig['view_cache']) {
            $html = Cache::get($viewCacheKey);
            if (!is_null($html)) {
                return $html;
            }
        }
        if (empty($no)) {
            return view('errors.404');
        }
        $form = Form::getInfoCache('no', (string)$no);
        if (empty($form) || $form->display == 0) {
            return view('errors.404');
        }
        $formFieldList = FormField::getListCache('form_id', $form->id, null, null, null, null, 'sequence ASC');
        $formData = new FormData($form->table);
        $builder = $formData::query();
        if (!empty($form->condition)) {
            $builder = $builder->whereRaw($form->condition);
        }
        $builder = $builder->orderByRaw($form->sort);
        $listRows = intval($form->page) <= 0 ? 10 : $form->page;
        $list = $formData->cachePaginate($builder, $listRows);
        $nav = [
            [
                'name' => $form->name,
                'url' => $url
            ],
        ];
        $common = $this->media($form->name);
        $model = new BaseModel();
        $renderView = empty($form->tpl) ? 'form.index' : $form->tpl;
        $html = View("home.{$systemConfig['theme']}.{$renderView}", compact(
            'nav',
            'common',
            'model',
            'form',
            'formFieldList',
            'list'
        ))->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_other_cache_time']) / 60);
        }
        return $html;
    }
}
