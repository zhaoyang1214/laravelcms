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
        DB::table('admin_auth')->insert(
            [
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
                    'id' => 111,
                    'pid' => 5,
                    'name' => '添加表单',
                    'controller' => 'form',
                    'action' => 'add',
                    'sequence' => 155,
                    'note' => '表单添加',
                    'icon' => ''
                ],
                [
                    'id' => 112,
                    'pid' => 5,
                    'name' => '查看',
                    'controller' => 'form',
                    'action' => 'info',
                    'sequence' => 160,
                    'note' => '查看表单',
                    'icon' => ''
                ],
                [
                    'id' => 113,
                    'pid' => 5,
                    'name' => '修改',
                    'controller' => 'form',
                    'action' => 'edit',
                    'sequence' => 165,
                    'note' => '修改表单',
                    'icon' => ''
                ],
                [
                    'id' => 114,
                    'pid' => 5,
                    'name' => '删除',
                    'controller' => 'form',
                    'action' => 'delete',
                    'sequence' => 170,
                    'note' => '删除表单',
                    'icon' => ''
                ],
                [
                    'id' => 115,
                    'pid' => 5,
                    'name' => '字段管理',
                    'controller' => 'formfield',
                    'action' => 'index',
                    'sequence' => 175,
                    'note' => '表单字段管理',
                    'icon' => ''
                ],
                [
                    'id' => 116,
                    'pid' => 5,
                    'name' => '数据管理',
                    'controller' => 'formdata',
                    'action' => 'index',
                    'sequence' => 180,
                    'note' => '表单数据管理',
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
                ],
                [
                    'id' => 1003,
                    'pid' => 108,
                    'name' => '添加管理组',
                    'controller' => 'admingroup',
                    'action' => 'add',
                    'sequence' => 1015,
                    'note' => '管理组添加',
                    'icon' => ''
                ],
                [
                    'id' => 1004,
                    'pid' => 108,
                    'name' => '查看',
                    'controller' => 'admingroup',
                    'action' => 'info',
                    'sequence' => 1020,
                    'note' => '管理组查看',
                    'icon' => ''
                ],
                [
                    'id' => 1005,
                    'pid' => 108,
                    'name' => '修改',
                    'controller' => 'admingroup',
                    'action' => 'edit',
                    'sequence' => 1025,
                    'note' => '管理组修改',
                    'icon' => ''
                ],
                [
                    'id' => 1006,
                    'pid' => 108,
                    'name' => '删除',
                    'controller' => 'admingroup',
                    'action' => 'delete',
                    'sequence' => 1030,
                    'note' => '管理组删除',
                    'icon' => ''
                ],
                [
                    'id' => 1007,
                    'pid' => 109,
                    'name' => '添加管理员',
                    'controller' => 'admin',
                    'action' => 'add',
                    'sequence' => 1035,
                    'note' => '管理员添加',
                    'icon' => ''
                ],
                [
                    'id' => 1008,
                    'pid' => 109,
                    'name' => '查看',
                    'controller' => 'admin',
                    'action' => 'info',
                    'sequence' => 1040,
                    'note' => '管理员查看',
                    'icon' => ''
                ],
                [
                    'id' => 1009,
                    'pid' => 109,
                    'name' => '修改',
                    'controller' => 'admin',
                    'action' => 'edit',
                    'sequence' => 1045,
                    'note' => '管理员修改',
                    'icon' => ''
                ],
                [
                    'id' => 1010,
                    'pid' => 109,
                    'name' => '删除',
                    'controller' => 'admin',
                    'action' => 'delete',
                    'sequence' => 1050,
                    'note' => '管理员删除',
                    'icon' => ''
                ],
                [
                    'id' => 1011,
                    'pid' => 109,
                    'name' => '修改资料',
                    'controller' => 'admin',
                    'action' => 'editInfo',
                    'sequence' => 1055,
                    'note' => '管理员修改资料',
                    'icon' => ''
                ],
                [
                    'id' => 1012,
                    'pid' => 115,
                    'name' => '添加字段',
                    'controller' => 'formfield',
                    'action' => 'add',
                    'sequence' => 1060,
                    'note' => '表单字段添加',
                    'icon' => ''
                ],
                [
                    'id' => 1013,
                    'pid' => 115,
                    'name' => '查看',
                    'controller' => 'formfield',
                    'action' => 'info',
                    'sequence' => 1065,
                    'note' => '表单字段查看',
                    'icon' => ''
                ],
                [
                    'id' => 1014,
                    'pid' => 115,
                    'name' => '修改',
                    'controller' => 'formfield',
                    'action' => 'edit',
                    'sequence' => 1070,
                    'note' => '表单字段修改',
                    'icon' => ''
                ],
                [
                    'id' => 1015,
                    'pid' => 115,
                    'name' => '删除',
                    'controller' => 'formfield',
                    'action' => 'delete',
                    'sequence' => 1075,
                    'note' => '表单字段删除',
                    'icon' => ''
                ],
                [
                    'id' => 1016,
                    'pid' => 116,
                    'name' => '添加数据',
                    'controller' => 'formdata',
                    'action' => 'add',
                    'sequence' => 1080,
                    'note' => '表单数据添加',
                    'icon' => ''
                ],
                [
                    'id' => 1017,
                    'pid' => 116,
                    'name' => '查看',
                    'controller' => 'formdata',
                    'action' => 'info',
                    'sequence' => 1085,
                    'note' => '表单数据查看',
                    'icon' => ''
                ],
                [
                    'id' => 1018,
                    'pid' => 116,
                    'name' => '修改',
                    'controller' => 'formdata',
                    'action' => 'edit',
                    'sequence' => 1090,
                    'note' => '表单数据修改',
                    'icon' => ''
                ],
                [
                    'id' => 1019,
                    'pid' => 116,
                    'name' => '删除',
                    'controller' => 'formdata',
                    'action' => 'delete',
                    'sequence' => 1095,
                    'note' => '表单数据删除',
                    'icon' => ''
                ]
            ]);
    }
}
