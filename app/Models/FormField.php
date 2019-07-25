<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * App\Models\FormField
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $form_id form表id
 * @property string $name 字段描述
 * @property string $field 字段名
 * @property int $type 字段类型，1：文本框；2：多行文本；3：编辑器，4：文件上传；5：单图片上传；6：组图上传；7：下拉菜单；8：单选；9：多选
 * @property int $property 字段属性，1：varchar；2：int；3：text；4：datetime；5：decimal；
 * @property int $len 字段长度
 * @property int $decimal 小数点位数
 * @property string $default 默认值
 * @property int $sequence 排序，越小越排在前面
 * @property string $tip 字段提示
 * @property string $config 字段配置
 * @property int $is_must 是否必填，0：否，1：是
 * @property int $is_unique 是否唯一，0：否，1：是
 * @property int $is_index 是否添加普通索引，0：否，1：是
 * @property string $regex 正则表达式验证
 * @property int $admin_display 是否后台显示，0：否，1：是
 * @property int $admin_display_len 后台列表显示长度
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereAdminDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereAdminDisplayLen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereDecimal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereIsIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereIsMust($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereIsUnique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereLen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereRegex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereTip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField whereUpdateTime($value)
 */
class FormField extends BaseModel
{

    protected $table = 'form_field';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'form_id',
        'name',
        'field',
        'type',
        'property',
        'len',
        'decimal',
        'default',
        'sequence',
        'tip',
        'config',
        'is_must',
        'is_unique',
        'is_index',
        'regex',
        'admin_display',
        'admin_display_len'
    ];

    public function getTypeProperty(int $type = null, $property = null)
    {
        $data = [
            1 => [
                'text' => '单行文本',
                'property' => [
                    1 => 'varchar',
                    2 => 'int',
                    4 => 'datetime',
                    5 => 'decimal'
                ]
            ],
            2 => [
                'text' => '多行文本',
                'property' => [
                    1 => 'varchar',
                    3 => 'text'
                ]
            ],
            3 => [
                'text' => '编辑器',
                'property' => [
                    3 => 'text',
                    1 => 'varchar'
                ]
            ],
            4 => [
                'text' => '文件上传',
                'property' => [
                    1 => 'varchar'
                ]
            ],
            5 => [
                'text' => '单图片上传',
                'property' => [
                    1 => 'varchar'
                ]
            ],
            6 => [
                'text' => '组图上传',
                'property' => [
                    3 => 'text',
                    1 => 'varchar'
                ]
            ],
            7 => [
                'text' => '下拉菜单',
                'property' => [
                    1 => 'varchar',
                    2 => 'int'
                ]
            ],
            8 => [
                'text' => '单选',
                'property' => [
                    1 => 'varchar',
                    2 => 'int'
                ]
            ],
            9 => [
                'text' => '多选',
                'property' => [
                    1 => 'varchar'
                ]
            ]
        ];
        if (is_null($type)) {
            return $data;
        }
        if (is_null($property)) {
            return $data[$type];
        }
        if ($property === false) {
            return $data[$type]['text'];
        }
        if ($property === true) {
            return $data[$type]['property'];
        }
        return $data[$type]['property'][$property];
    }

    public function add(array $data)
    {
        try {
            $form = Form::find($data['form_id']);
            Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data) {
                switch ($data['property']) {
                    case 1:
                        $fieldObj = $table->string($data['field'], $data['len']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 2:
                        $fieldObj = $table->integer($data['field']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 3:
                        $table->text($data['field']);
                        break;
                    case 4:
                        $fieldObj = $table->dateTime($data['field']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 5:
                        $len = $data['len'] > 65 ? 65 : $data['len'];
                        $decimal = $data['decimal'] > 30 ? 30 : $data['decimal'];
                        $fieldObj = $table->decimal($data['field'], $len + $decimal, $decimal);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                }
                if ($data['is_unique'] == 1) {
                    $table->unique($data['field'], $data['field']);
                } else if ($data['is_index'] == 1) {
                    $table->index($data['field'], $data['field']);
                }
            });
            $res = self::create($data);
            if (! $res) {
                Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data) {
                    if ($data['is_unique'] == 1) {
                        $table->dropUnique($data['field']);
                    } else if ($data['is_index'] == 1) {
                        $table->dropIndex($data['field']);
                    }
                    $table->dropColumn($data['field']);
                });
            }
            return $res;
        } catch (\Exception $e) {
            return $this->appendMessage($e->getMessage());
        }
    }

    public function getOne(int $id)
    {
        $info = self::find($id);
        if (! $info) {
            return $this->appendMessage('该字段不存在');
        }
        $formInfo = (new Form())->getOne($info->form_id);
        if (! $formInfo) {
            return $this->appendMessage('该字段不存在');
        }
        return $info;
    }

    public function edit(int $id, array $data)
    {
        $info = self::find($id);
        $form = Form::find($info->form_id);
        Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data, $info) {
            if ($info->is_unique == 1 && $data['is_unique'] == 0) {
                $table->dropUnique($info->field);
            } else if ($info->is_unique == 0) {
                if ($data['is_unique'] == 1) {
                    if ($info->is_index == 1) {
                        $table->dropIndex($info->field);
                    }
                    $table->unique($info->field, $info->field);
                } else if ($info->is_index == 1 && $data['is_index'] == 0) {
                    $table->dropIndex($info->field);
                } else if ($info->is_index == 0 && $data['is_index'] == 1) {
                    $table->index($info->field, $info->field);
                }
            }
        });
        return $info->fill($data)->save();
    }

    public function deleteById(int $id)
    {
        $info = $this->getOne($id);
        if (! $info) {
            return $this->appendMessage('该字段不存在');
        }
        $form = Form::find($info->form_id);
        Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($info) {
            $table->dropColumn($info->field);
        });
        return $info->delete();
    }

    public function getFieldHtml($formData = null)
    {
        if (! isset($this->id)) {
            return '';
        }
        $value = is_null($formData) ? $this->default : ($formData->{$this->field} ?? '');
        $layVerify = $this->is_must ? 'required' : '';
        switch ($this->type) {
            case 1: // 单行文本框
                $script = '';
                $layuiDisabled = '';
                switch ($this->property) {
                    case 2:
                    case 5:
                        $layVerify .= empty($layVerify) ? 'number' : '|number';
                        break;
                    case 4:
                        $layuiDisabled = 'layui-disabled';
                        $config = empty($this->config) ? [] : json_decode($this->config, true);
                        $phpFormat = $config['php_format'] ?? 'Y-m-d H:i:s';
                        $laydateType = $config['laydate_type'] ?? 'datetime';
                        $laydateFormat = $config['laydate_format'] ?? 'yyyy-MM-dd HH:mm:ss';
                        if (! empty($value)) {
                            $value = date($phpFormat, strtotime($value));
                        }
                        $script = <<<EOF
                            <script>
                        		layui.use(['laydate'], function(){
                        			var laydate = layui.laydate;
                                 	laydate.render({
                                 	   elem: '#{$this->field}',
                                  	   type: '$laydateType',
                                  	   format: "$laydateFormat"
                                 	});
                        		});		
                        	</script>
EOF;
                        break;
                }
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				<input type="text" id="$this->field" name="$this->field" value="$value" lay-verify="$layVerify" autocomplete="off" class="layui-input $layuiDisabled">
        			</div>
                    $script
EOF;
                break;
            case 2: // 多行文本框
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				<textarea id="$this->field" name="$this->field"  lay-verify="$layVerify" class="layui-textarea">$value</textarea>
        			</div>
EOF;
                break;
            case 3: // 编辑器
                $value = htmlspecialchars_decode($value);
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xxxxlarge">
        				<script src="/admin/js/ueditor.config.js" type="text/javascript"></script>
                 		<script src="/lib/ueditor/ueditor.all.js" type="text/javascript"></script>
                 		<script src="/lib/ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
                 		<script name="{$this->field}" id="{$this->field}" type="text/plain" style="width:100%; height:400px;">$value</script>
                 		<script type="text/javascript">UE.getEditor("{$this->field}", {"serverUrl":"/admin/ueditor/index?origin=4"});</script>
        			</div>
EOF;
                break;
            case 4: // 文件上传
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				<div class="layui-input-inline input-large">
        					<input type="text" name="{$this->field}" id="{$this->field}" value="$value" lay-verify="$layVerify" autocomplete="off" placeholder="请选择文件" class="layui-input layui-disabled">
        				</div>
        				<div class="layui-input-inline input-mini">
        					<button type="button" class="layui-btn" id="upload-{$this->field}">上传文件</button>
        				</div>
        				<script type="text/javascript">
                		$("#upload-{$this->field}").click(function() {
                        	layer.open({
                                type: 2,
                                title: ['上传文件', 'font-weight: bold;font-size:larger;'],
                                area: ['818px', '500px'],
                                shade: 0,
                                maxmin:true,
                                content: '/admin/ueditor/getUpfileHtml?type=file&origin=4&id={$this->field}',
                                zIndex: layer.zIndex
                              });
                        });
                		</script>
        			</div>
EOF;
                break;
            case 5: // 单图片上传
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				<div class="layui-input-inline input-large">
        					<input type="text" name="{$this->field}" id="{$this->field}"  value="$value" lay-verify="$layVerify" autocomplete="off" placeholder="请选择图片" class="layui-input layui-disabled">
        				</div>
        				<div class="layui-input-inline input-mini">
        					<button type="button" class="layui-btn" id="upload-{$this->field}">上传图片</button>
        				</div>
        				<script type="text/javascript">
                		$("#upload-{$this->field}").click(function() {
                        	var height = $(window).height() - 2;
                        	layer.open({
                                type: 2,
                                title: ['上传图片', 'font-weight: bold;font-size:larger;'],
                                area: ['818px', height < '668' ? (height + 'px') : '668px'],
                                shade: 0,
                                maxmin:true,
                                content: '/admin/ueditor/getUpfileHtml?type=image&origin=4&id={$this->field}',
                                zIndex: layer.zIndex
                              });
                        });
                		</script>
        			</div>
EOF;
                break;
            case 6: // 组图上传
                $values = json_decode($value, true) ?? [];
                $liHtml = '';
                foreach ($values as $v) {
                    $liHtml .= <<<EOF
                        <li>
        		             <div class="pic" id="images_button">
        		             <img src="{$v['thumbnail_url']}" width="125" height="105" />
        			              <input  id="{$this->field}_url[]" name="{$this->field}_url[]" type="hidden" value="{$v['url']}" />
        			              <input  id="{$this->field}_thumbnail_url[]" name="{$this->field}_thumbnail_url[]" type="hidden" value="{$v['thumbnail_url']}" />
        		             </div>
        		             <div class="title">标题： <input name="{$this->field}_title[]" type="text" id="{$this->field}_title[]" value="{$v['title']}" /></div>
        		             <div class="title">排序： <input id="{$this->field}_order[]" name="{$this->field}_order[]" value="{$v['order']}" type="text" style="width:50px;" /> <a href="javascript:void(0);" onclick="$(this).parent().parent().remove()">删除</a></div>
        		         </li>
EOF;
                }
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xxxxlarge">
        				<button type="button" class="layui-btn" id="{$this->field}_button">上传多图</button>
        				<div class="fn_clear"></div>
        				<div class="images">
                	        <ul id="{$this->field}_list" class="images_list">
                		      {$liHtml} 
                	        </ul>
                            <div style="clear:both"></div>
                       	</div>
                       	<script>
                	        $("#{$this->field}_button").click(function() {
                            	var height = $(window).height() - 2;
                            	layer.open({
                                    type: 2,
                                    title: ['组图上传', 'font-weight: bold;font-size:larger;'],
                                    area: ['818px', height < '668' ? (height + 'px') : '668px'],
                                    shade: 0,
                                    maxmin:true,
                                    content: '/admin/ueditor/getUpfileHtml?type=images&origin=4&id={$this->field}',
                                    zIndex: layer.zIndex
                                  });
                            });
                        </script>
        			</div>
EOF;
                break;
            case 7: // 下拉菜单
                $configArr = empty($this->config) ? [] : json_decode($this->config, true);
                $optionHtml = '';
                foreach ($configArr as $v => $title) {
                    $selected = $v == $value ? 'selected="selected"' : '';
                    $optionHtml .= "<option value='{$v}' {$selected}>{$title}</option>";
                }
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				<select name="{$this->field}" id="{$this->field}">
        					$optionHtml
        				</select>
        			</div>
EOF;
                break;
            case 8: // 单选
                $configArr = empty($this->config) ? [] : json_decode($this->config, true);
                $inputHtml = '';
                foreach ($configArr as $v => $title) {
                    $checked = $v == $value ? 'checked="checked"' : '';
                    $inputHtml .= "<input type='radio' name='{$this->field}' value='{$v}' title='{$title}' $checked >";
                }
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				$inputHtml
        			</div>
EOF;
                break;
            case 9: // 多选
                $configArr = empty($this->config) ? [] : json_decode($this->config, true);
                $inputHtml = '';
                foreach ($configArr as $v => $title) {
                    $checked = $v == $value ? 'checked="checked"' : '';
                    $inputHtml .= "<input type='checkbox' name='{$this->field}[]' value='{$v}' title='{$title}' $checked  class='keep'>";
                }
                $fieldHtml = <<<EOF
                    <div class="layui-input-inline input-xlarge">
        				$inputHtml
        			</div>
EOF;
                break;
        }
        $html = <<<EOF
            <div class="layui-form-item">
    			<label for="{$this->field}" class="layui-form-label form-label-large">$this->name</label>
    			$fieldHtml
    			<div class="layui-form-mid layui-word-aux">$this->tip</div>
    		</div>
EOF;
        return $html;
    }

    public function getFieldValue($formData)
    {
        if (! isset($this->id)) {
            return '';
        }
        $value = is_array($formData) ? $formData[$this->field] : $formData->{$this->field};
        switch ($this->type) {
            // 单行文本框
            case 1:
                switch ($this->property) {
                    case 1:
                        if ($this->admin_display_len) {
                            $suffix = mb_strlen($value) > $this->admin_display_len ? '...' : '';
                            $value = mb_substr($value, 0, $this->admin_display_len) . $suffix;
                        }
                        break;
                    case 2:
                    case 5:
                        break;
                    case 4:
                        $config = empty($this->config) ? [] : json_decode($this->config, true);
                        $phpFormat = $config['php_format'] ?? 'Y-m-d H:i:s';
                        $value = ! empty($value) ? date($phpFormat, strtotime($value)) : $value;
                        break;
                }
                break;
            // 多行文本框
            case 2:
                if ($this->admin_display_len) {
                    $suffix = mb_strlen($value) > $this->admin_display_len ? '...' : '';
                    $value = mb_substr($value, 0, $this->admin_display_len) . $suffix;
                }
                break;
            // 编辑器
            case 3:
                $value = htmlspecialchars_decode($value);
                if ($this->admin_display_len) {
                    $suffix = mb_strlen($value) > $this->admin_display_len ? '...' : '';
                    $value = mb_substr($value, 0, $this->admin_display_len) . $suffix;
                }
                break;
            // 文件上传
            case 4:
                $value = '<a href="' . $value . '">' . basename($value) . '</a>';
                break;
            // 单图片上传
            case 5:
                $value = '<img src="' . $value . '" alt="" style="max-width:170px; max-height:90px; _width:170px; _height:90px;" />';
                break;
            // 组图上传
            case 6:
                $values = json_decode($value, true) ?? [];
                $value = '';
                foreach ($values as $k => $v) {
                    if ($this->admin_display_len && $this->admin_display_len == $k) {
                        break;
                    }
                    $value .= '<img src="' . $v['thumbnail_url'] . '" alt="' . $v['title'] . '" style="max-width:170px; max-height:90px; _width:170px; _height:90px;margin-left: 5px;" />';
                }
                break;
            // 下拉
            case 7:
            // 单选
            case 8:
                $configArr = empty($this->config) ? [] : json_decode($this->config, true);
                foreach ($configArr as $v => $title) {
                    if ($v == $value) {
                        $value = $title;
                        break;
                    }
                }
                break;
            // 多选
            case 9:
                $configArr = empty($this->config) ? [] : json_decode($this->config, true);
                $values = explode(',', $value);
                $value = '';
                $i = 0;
                foreach ($configArr as $v => $title) {
                    if ($this->admin_display_len && $this->admin_display_len == $i ++) {
                        $value .= count($values) > $this->admin_display_len ? '...' : '';
                        break;
                    }
                    if (in_array($v, $values)) {
                        $value .= $title . ' ';
                    }
                }
                break;
        }
        return $value;
    }
}
