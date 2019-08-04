<?php
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_config')->truncate();
        DB::table('system_config')->insert([
            [
                'name' => 'sitename',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'seoname',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'siteurl',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'keywords',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'description',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'masteremail',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'copyright',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'registered_no',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'telephone',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'linkman',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'fax',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'qq',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'addr',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'db_cache',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'db_cache_time',
                'value' => '86400',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'view_cache',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'html_index_cache_time',
                'value' => '86400',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'html_other_cache_time',
                'value' => '86400',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'html_search_cache_time',
                'value' => '86400',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'theme',
                'value' => 'default',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'index_tpl',
                'value' => 'index.index',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'search_tpl',
                'value' => 'search.index',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'tags_index_tpl',
                'value' => 'tags.index',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'tags_info_tpl',
                'value' => 'tags.info',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'tpl_seach_page',
                'value' => '20',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'tpl_tags_index_page',
                'value' => '20',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'tpl_tags_page',
                'value' => '20',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'upload_switch',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'file_size',
                'value' => '2',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'file_num',
                'value' => '10',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'image_type',
                'value' => 'png,jpg,jpeg,gif,bmp',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'video_type',
                'value' => 'flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'file_type',
                'value' => 'png,jpg,jpeg,gif,bmp,flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid,rar,zip,tar,gz,7z,bz2,cab,iso,doc,docx,xls,xlsx,ppt,pptx,pdf,txt,md,xml',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'thumbnail_switch',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'thumbnail_cutout',
                'value' => '1',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'thumbnail_maxwidth',
                'value' => '210',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'thumbnail_maxheight',
                'value' => '110',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'watermark_switch',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'watermark_place',
                'value' => '9',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'watermark_image',
                'value' => '',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'content_preview',
                'value' => '0',
                'create_time' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
