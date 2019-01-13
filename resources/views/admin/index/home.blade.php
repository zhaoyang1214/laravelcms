@extends('admin.layouts.common')

@section('content')
<div class="x-body layui-anim layui-anim-up">
    <blockquote class="layui-elem-quote">欢迎登陆：<span class="x-red">{{ $adminInfo['nickname'] }}</span>！  您当前登录时间为：{{ $loginInfo['loginTime'] }}  登录IP为: {{ $loginInfo['loginIp'] }}</blockquote>
    <fieldset class="layui-elem-field">
        <legend>数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>栏目数</h3>
                                            <p>
                                                <cite>{{ $categoryCount }}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>内容数</h3>
                                            <p>
                                                <cite>{{ $contentCount }}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>TAG数</h3>
                                            <p>
                                                <cite>{{ $tagsCount }}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>附件数</h3>
                                            <p>
                                                <cite>{{ $uploadCount }}</cite></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <th width="15%">程序版本</th>
                        <td width="35%">v1.0.0</td>
                        <th width="15%">laravel版本</th>
                        <td width="35%">v{{ app()::VERSION }}</td>
                    </tr>
                    <tr>
                        <th>当前环境</th>
                        <td><font color="@if(env('APP_ENV') == 'production')gree @else red @endif">{{ env('APP_ENV') }}</font></td>
                        <th>debug状态</th>
                        <td>@if(env('APP_ENV'))<font  title="开启" color="red">开启</font> @else <font  title="未开启" color="gree">未开启</font> @endif</td>
                    </tr>
                    <tr>
                        <th>当前模板</th>
                        <td>default</td>
                        <th>缓存状态</th>
                        <td> @if(config('system.db_cache'))<font  title="开启" color="gree">数据库</font> @else <font  title="未开启" color="red">数据库</font> @endif @if(config('system.view_cache'))<font  title="开启" color="gree">视图</font> @else <font  title="未开启" color="red">视图</font> @endif</td>
                    </tr>
                    <tr>
                        <td>操作系统</td>
        				<td>{{ PHP_OS }}</td>
        				<th>服务器地址</th>
                        <td>{{ $_SERVER['SERVER_ADDR'] }}:{{  $_SERVER['SERVER_PORT']}}</td>
        			</tr>
                    <tr>
                        <th>服务器时间</th>
                        <td>{{ date('Y-m-d G:i T') }}</td>
                        <th>WEB服务器</th>
                        <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                    </tr>
                    <tr>
                        <th>服务器语言</th>
                        <td>{{ $_SERVER['HTTP_ACCEPT_LANGUAGE'] }}</td>
                        <th>PHP版本</th>
                        <td>{{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <th>图像处理支持</th>
                        <td>@if(function_exists('gd_info'))<font color=green><b>√</b></font>@else<font color=red><b>×</b></font>@endif</td>
                        <th>脚本运行内存</th>
                        <td>{{ get_cfg_var('memory_limit') }}</td>
                    </tr>
                    <tr>
                        <th>上传大小限制</th>
                        <td>{{ get_cfg_var('upload_max_filesize') }}</td>
                        <th>POST提交限制</th>
                        <td>{{ get_cfg_var('post_max_size') }}</td>
                    </tr>
                    <tr>
                        <th>脚本超时时间</th>
                        <td>{{ get_cfg_var('max_execution_time') }}</td>
                        <th>被屏蔽的函数</th>
                        <td>{{ get_cfg_var('disable_functions') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </fieldset>
</div>
@endsection