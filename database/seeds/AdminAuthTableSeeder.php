<?php
use Illuminate\Database\Seeder;

class AdminAuthTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_auth')->truncate();
        DB::table('admin_auth')->insert([
            [
                'id' => 1,
                'pid' => 0,
                'name' => '首页管理',
                'controller' => '',
                'action' => '',
                'sequence' => 5,
                'note' => '首页管理',
                'icon' => 'layui-icon-home'
            ],
            [
                'id' => 2,
                'pid' => 0,
                'name' => '栏目管理',
                'controller' => 'category',
                'action' => 'index',
                'sequence' => 10,
                'note' => '栏目管理',
                'icon' => 'layui-icon-component'
            ],
            [
                'id' => 3,
                'pid' => 0,
                'name' => '内容管理',
                'controller' => 'content',
                'action' => 'index',
                'sequence' => 15,
                'note' => '内容管理',
                'icon' => 'layui-icon-read'
            ],
            [
                'id' => 4,
                'pid' => 0,
                'name' => '扩展管理',
                'controller' => '',
                'action' => '',
                'sequence' => 20,
                'note' => '扩展管理',
                'icon' => 'layui-icon-senior'
            ],
            [
                'id' => 5,
                'pid' => 0,
                'name' => '表单管理',
                'controller' => 'form',
                'action' => 'index',
                'sequence' => 25,
                'note' => '表单管理',
                'icon' => 'layui-icon-form'
            ],
            [
                'id' => 6,
                'pid' => 0,
                'name' => '安全管理',
                'controller' => '',
                'action' => '',
                'sequence' => 30,
                'note' => '安全管理',
                'icon' => 'layui-icon-auz'
            ],
            [
                'id' => 100,
                'pid' => 1,
                'name' => '系统设置',
                'controller' => 'systemset',
                'action' => 'index',
                'sequence' => 100,
                'note' => '系统设置',
                'icon' => ''
            ],
            [
                'id' => 101,
                'pid' => 1,
                'name' => '栏目模型',
                'controller' => 'categorymodel',
                'action' => 'index',
                'sequence' => 105,
                'note' => '栏目模型管理',
                'icon' => ''
            ],
            [
                'id' => 102,
                'pid' => 4,
                'name' => '扩展模型',
                'controller' => 'expand',
                'action' => 'index',
                'sequence' => 110,
                'note' => '扩展模型管理',
                'icon' => ''
            ],
            [
                'id' => 103,
                'pid' => 4,
                'name' => '自定义变量',
                'controller' => 'fragment',
                'action' => 'index',
                'sequence' => 115,
                'note' => '自定义变量管理',
                'icon' => ''
            ],
            [
                'id' => 104,
                'pid' => 4,
                'name' => '内容替换',
                'controller' => 'replace',
                'action' => 'index',
                'sequence' => 120,
                'note' => '内容替换',
                'icon' => ''
            ],
            [
                'id' => 105,
                'pid' => 4,
                'name' => 'TAG管理',
                'controller' => 'tags',
                'action' => 'index',
                'sequence' => 125,
                'note' => 'TAG管理',
                'icon' => ''
            ],
            [
                'id' => 106,
                'pid' => 4,
                'name' => '推荐位管理',
                'controller' => 'position',
                'action' => 'index',
                'sequence' => 130,
                'note' => '推荐位管理',
                'icon' => ''
            ],
            [
                'id' => 107,
                'pid' => 4,
                'name' => '附件管理',
                'controller' => 'upload',
                'action' => 'index',
                'sequence' => 135,
                'note' => '附件管理',
                'icon' => ''
            ],
            [
                'id' => 108,
                'pid' => 6,
                'name' => '管理组管理',
                'controller' => 'admingroup',
                'action' => 'index',
                'sequence' => 140,
                'note' => '管理组管理',
                'icon' => ''
            ],
            [
                'id' => 109,
                'pid' => 6,
                'name' => '管理员管理',
                'controller' => 'admin',
                'action' => 'index',
                'sequence' => 145,
                'note' => '管理员管理',
                'icon' => ''
            ],
            [
                'id' => 110,
                'pid' => 6,
                'name' => '后台登录记录',
                'controller' => 'adminlog',
                'action' => 'index',
                'sequence' => 150,
                'note' => '后台登录记录',
                'icon' => ''
            ],
            [
                'id' => 1000,
                'pid' => 100,
                'name' => '保存',
                'controller' => 'systemset',
                'action' => 'save',
                'sequence' => 1000,
                'note' => '系统设置保存',
                'icon' => ''
            ],
            [
                'id' => 1001,
                'pid' => 101,
                'name' => '查看',
                'controller' => 'categorymodel',
                'action' => 'info',
                'sequence' => 1005,
                'note' => '查看栏目模型详情',
                'icon' => ''
            ],
            [
                'id' => 1002,
                'pid' => 101,
                'name' => '修改',
                'controller' => 'categorymodel',
                'action' => 'edit',
                'sequence' => 1010,
                'note' => '栏目模型修改',
                'icon' => ''
            ]
        ]);
    }
}
