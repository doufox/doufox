<?php
if (!defined('IN_CMS')) {
    exit();
}

/**
 * 字段操作函数库
 */
function form_type()
{
    $formtype = function_exists('_formtype') ? _formtype() : null;
    $return = array(
        'input' => '单行文本',
        'textarea' => '多行文本',
        'editor' => '编辑器',
        'select' => '下拉选择框',
        'radio' => '单选按钮',
        'checkbox' => '复选框',
        'image' => '单图上传',
        'file' => '文件上传',
        'files' => '多文件上传',
        'date' => '日期时间',
        'merge' => '组合字段',
        'fields' => '多字段组合',
    );
    return $formtype && is_array($formtype) ? array_merge($formtype, $return) : $return;
}

/**
 * 以下函数作用于字段添加/修改部分
 */
function form_input($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">长度 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . (isset($setting['size']) ? $setting['size'] : '150') . '" name="setting[size]"><font color="gray">px</font></td>
    </tr>
    <tr>
      <td>默认值 ：</td>
      <td><input type="text" class="form-control" size="30" value="' . (isset($setting['default']) ? $setting['default'] : '') . '" name="setting[default]"></td>
    </tr>
    </tbody>
    </table>';
}

function form_textarea($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">宽度 ：</td>
      <td><input type="text" class="form-control" size="20" value="' . (isset($setting['width']) ? $setting['width'] : '400') . '" name="setting[width]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>高度 ：</td>
      <td><input type="text" class="form-control" size="20" value="' . (isset($setting['height']) ? $setting['height'] : '90') . '" name="setting[height]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>默认值 ：</td>
      <td><textarea class="form-control" name="setting[default]" rows="2" cols="30">' . (isset($setting['default']) ? $setting['default'] : '') . '</textarea></td>
    </tr>
    </tbody>
    </table>';
}

function form_editor($setting = '')
{
    $t = isset($setting['type']) && $setting['type'] ? 1 : (!isset($setting['type']) ? 1 : 0);
    $w = isset($setting['width']) ? $setting['width'] : '100';
    $h = isset($setting['height']) ? $setting['height'] : '300';
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">宽度 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . $w . '" name="setting[width]">
      <font color="gray">%</font>
      </td>
    </tr>
    <tr>
      <td>高度 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . $h . '" name="setting[height]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>类型 ：</td>
      <td>
          <label class="label-group"><input type="radio" value=1 name="setting[type]" ' . ($t == 1 ? 'checked' : '') . '> 完整模式</label>
          <label class="label-group"><input type="radio" value=0 name="setting[type]"' . ($t == 0 ? 'checked' : '') . '> 精简模式</label>
      </td>
    </tr>
    <tr>
      <td>默认值 ：</td>
      <td><textarea class="form-control" name="setting[default]" rows="2" cols="30">' . (isset($setting['default']) ? $setting['default'] : '') . '</textarea></td>
    </tr>
    </tbody>
    </table>';
}

function form_select($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="170">选项列表 ：</td>
      <td><textarea class="form-control" name="setting[content]" style="width:195px;height:100px;">' . (isset($setting['content']) ? $setting['content'] : '') . '</textarea>
      <font color="gray">格式：选项名称1|选项值1 (回车换行)。</font>
      </td>
    </tr>
    <tr>
      <td>默认选中值 ：</td>
      <td><input type="text" class="form-control" style="width:200px;" value="' . (isset($setting['default']) ? $setting['default'] : '') . '" name="setting[default]"></td>
    </tr>
    </tbody>
    </table>';
}

function form_radio($setting = '')
{
    return form_select($setting);
}

function form_checkbox($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="170">选项列表 ：</td>
      <td><textarea class="form-control" name="setting[content]" style="width:195px;height:100px;">' . (isset($setting['content']) ? $setting['content'] : '') . '</textarea>
      <font color="gray">格式：选项名称1|选项值1 (回车换行)。</font>
      </td>
    </tr>
    <tr>
      <td>默认选中值 ：</td>
      <td><input type="text" class="form-control" style="width:200px;" value="' . (isset($setting['default']) ? $setting['default'] : '') . '" name="setting[default]">
      <br><font color="gray">多个选中值以分号分隔“,”，格式：选中值1,选中值2。</font>
      </td>
    </tr>
    </tbody>
    </table>';
}

function form_image($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">宽度 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . (isset($setting['width']) ? $setting['width'] : '200') . '" name="setting[width]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>高度 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . (isset($setting['height']) ? $setting['height'] : '160') . '" name="setting[height]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>大小 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . (isset($setting['size']) ? $setting['size'] : '2') . '" name="setting[size]">
      <font color="gray">MB</font>
      </td>
    </tr>
    </tbody>
    </table>';
}

function form_file($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">格式 ：</td>
      <td><input type="text" class="form-control" size="50" value="' . (isset($setting['type']) ? $setting['type'] : '') . '" name="setting[type]">
      <font color="gray">多个格式以,号分开，如：zip,rar,tar</font>
      </td>
    </tr>
    <tr>
      <td>大小 ：</td>
      <td><input type="text" class="form-control" size="10" value="' . (isset($setting['size']) ? $setting['size'] : '2') . '" name="setting[size]">
      <font color="gray">MB</font>
      </td>
    </tr>
    </tbody>
    </table>';
}

function form_files($setting = '')
{
    return form_file($setting);
}

function form_date($setting = '')
{
    $type = isset($setting['type']) && $setting['type'] ? $setting['type'] : '%Y-%m-%d %H:%M:%S';
    $width = isset($setting['width']) && $setting['width'] ? $setting['width'] : 150;
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">宽度 ：</td>
      <td><input type="text" class="form-control" size="7" value="' . $width . '" name="setting[width]">
      <font color="gray">px</font>
      </td>
    </tr>
    <tr>
      <td>格式 ：</td>
      <td><input type="text" class="form-control" size="25" value="' . $type . '" name="setting[type]">
      <font color="gray">格式%Y-%m-%d %H:%M:%S表示2014-02-13 11:20:20。</font>
      </td>
    </tr>
    </tbody>
    </table>';
}

function form_merge($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="150">组合字段 ：</td>
      <td><input type="text" name="setting[content]" class="form-control" value="' . (isset($setting['content']) ? $setting['content'] : '') . '" size=50>
      </td>
    </tr>
    <tr>
      <td>格式 ：</td>
      <td><font color="gray">{字段名称}[介绍]，例如：{shi}室，{ting}厅，{wei}卫</font></td>
    </tr>
    </tbody>
    </table>';
}

function form_fields($setting = '')
{
    return '
    <table width="98%" cellspacing="1" cellpadding="2">
    <tbody>
    <tr>
      <td width="100">多字段组合 ：</td>
      <td><textarea class="form-control" name="setting[content]" style="width:444px;height:200px;">' . (isset($setting['content']) ? $setting['content'] : '') . '</textarea>
      </td>
    </tr>
    <tr>
      <td>格式 ：</td>
      <td><font color="gray">{字段名称}[介绍]，例如：{shi}室，{ting}厅，{wei}卫</font></td>
    </tr>
    </tbody>
    </table>';
}

function get_content_value($content)
{
    if ($content != '' && preg_match('/^\{M:(.+)\}$/U', $content, $field)) {
        if (core::get_namespace_id() == 'admin') {
            return null;
        }

        if (!$this->cookie->get('member_id')) {
            return null;
        }

        if (!$this->cookie->get('member_id')) {
            return null;
        }

        $name = trim($field[1]);
        $member = core::load_model('member');
        $data = $member->find($this->cookie->get('member_id'));
        if (isset($data[$name])) {
            return $data[$name];
        }

        $model = get_cache('membermodel');
        $_member = core::load_model($model[$data['modelid']]['tablename']);
        $_data = $_member->find($this->cookie->get('member_id'));
        if (isset($_data[$name])) {
            return $_data[$name];
        }

    } else {
        return $content;
    }
}

/**
 * 以下函数作用于发布内容部分
 */

function content_input($name, $content = '', $setting = '')
{
    $content = is_null($content[0]) ? get_content_value($setting['default']) : $content[0];
    $style = isset($setting['size']) ? " style='width:" . ($setting['size'] ? $setting['size'] : 150) . "px;'" : '';
    return '<input type="text" value="' . $content . '" class="form-control" name="data[' . $name . ']" ' . $style . '>';
}

function content_textarea($name, $content = '', $setting = '')
{
    $content = is_null($content[0]) ? get_content_value($setting['default']) : $content[0];
    $style = isset($setting['width']) && $setting['width'] ? 'width:' . $setting['width'] . 'px;' : '';
    $style .= isset($setting['height']) && $setting['height'] ? 'height:' . $setting['height'] . 'px;' : '';
    return '<textarea class="form-control" style="' . $style . '" name="data[' . $name . ']">' . $content . '</textarea>';
}

function content_editor($name, $content = '', $setting = '')
{
    $content = is_null($content[0]) ? get_content_value($setting['default']) : $content[0];
    $w = isset($setting['width']) && $setting['width'] ? $setting['width'] : '98';
    $h = isset($setting['height']) && $setting['height'] ? $setting['height'] : '400';
    $id = $name;
    $type = isset($setting['type']) && $setting['type'] ? 1 : (!isset($setting['type']) ? 1 : 0);
    $str = '';
    $page = !isset($setting['system']) && $name == 'content' ? ", '|', 'pagebreak'" : '';
    $source = strpos($_SERVER['QUERY_STRING'], 's=admin') === false || strpos($_SERVER['QUERY_STRING'], 's=admin') === false ? '' : "'source', '|',";
    if (!defined('CMS_EDITOR_LD')) {
        $str .= '<script type="text/javascript" src="/static/kindeditor/kindeditor.js"></script>';
        define('CMS_EDITOR_LD', 1); // 防止重复加载JS
    }
    if ($type) {
        $str .= "
        <script type=\"text/javascript\">KindEditor.ready(function(K) {
            K.create('#" . $id . "', {
                allowFileManager : true,
                resizeType : 0,
                items : [
                    " . $source . "  'preview', 'code', 'paste',
                    'plainpaste', 'wordpaste', '|', 'image',
                    'flash', 'media', 'table', 'hr',  'baidumap',  'link', 'unlink' , '|', 'justifyleft', 'justifycenter', 'justifyright',
                    'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                    'superscript', 'clearhtml', 'quickformat',  '|', 'formatblock', 'fontname', 'fontsize', '|', 'forecolor',  'bold',
                    'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat'" . $page . "
                ]
            });
        });
        </script>";
    } else {
        $str .= "
        <script type=\"text/javascript\">KindEditor.ready(function(K) {
            K.create('#" . $id . "', {
                allowFileManager : true,
                allowImageUpload : false,
                resizeType : 0 ,
                items : [
                    " . $source . " 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'image', 'link' , 'clearhtml'
                ]
            });
        });
        </script>";
    }
    $str .= '<textarea class="form-control" id="' . $id . '" name="data[' . $name . ']" style="width:' . $w . '%;height:' . $h . 'px;visibility:hidden;">' . $content . '</textarea>';
    if (!isset($setting['system']) && $name == 'content') {
        $str .= '<br /><p><label class="label-group"><input type="checkbox" checked="" value="1" name="data[add_introduce]">自动生成描述</label>';
        $str .= '<input type="text" size="10" value="200" name="data[introcude_length]" class="form-control">字符描述<p>';
        $str .= '<p><label class="label-group"><input type="checkbox" checked="" value="1" name="data[auto_thumb]">自动获取第一张图为缩略图</label></p>';
    }
    return $str;
}

function content_select($name, $content = '', $setting = '')
{
    $content = is_null($content[0]) ? get_content_value($setting['default']) : $content[0];
    $select = explode(chr(13), $setting['content']);
    $str = '<select class="form-control" id="' . $name . '" name="data[' . $name . ']">';
    foreach ($select as $t) {
        $n = $v = $selected = '';
        list($n, $v) = explode('|', $t);
        $v = is_null($v) ? trim($n) : trim($v);
        $selected = $v == $content ? ' selected' : '';
        $str .= "<option value='" . $v . "'" . $selected . ">" . $n . "</option>";
    }
    return $str . '</select>';
}

function content_radio($name, $content = '', $setting = '')
{
    $content = is_null($content[0]) ? get_content_value($setting['default']) : $content[0];
    $select = explode(chr(13), $setting['content']);
    $str = '';
    foreach ($select as $t) {
        $n = $v = $selected = '';
        list($n, $v) = explode('|', $t);
        $v = is_null($v) ? trim($n) : trim($v);
        $selected = $v == $content ? ' checked' : '';
        $str .= $n . '<input type="radio" name="data[' . $name . ']" value="' . $v . '" ' . $selected . '/>&nbsp;&nbsp;';
    }
    return $str;
}

function content_checkbox($name, $content = '', $setting = '')
{
    $default = get_content_value($setting['default']);
    $content = is_null($content[0]) ? ($default ? @explode(',', $default) : '') : string2array($content[0]);
    $select = explode(chr(13), $setting['content']);
    $str = '';
    foreach ($select as $t) {
        $n = $v = $selected = '';
        list($n, $v) = explode('|', $t);
        $v = is_null($v) ? trim($n) : trim($v);
        $selected = is_array($content) && in_array($v, $content) ? ' checked' : '';
        $str .= $n . '&nbsp;<input type="checkbox" name="data[' . $name . '][]" value="' . $v . '" ' . $selected . ' />&nbsp;&nbsp;';
    }
    return $str;
}

function content_image($name, $content = '', $setting = '')
{
    $content = $content[0];
    $size = (int) $setting['size'];
    $height = isset($setting['height']) ? $setting['height'] : '';
    $width = isset($setting['width']) ? $setting['width'] : '';
    $str = '
    <div id="imgPreview' . $name . '"></div>
    <div class="input-group">
        <input type="text" class="form-control" size="50" value="' . $content . '" name="data[' . $name . ']" id="' . $name . '" onmouseover="admin_command.preview_img(\'' . $name . '\')">
        <div class="input-group-btn">
            <button type="button" class="btn btn-default" onClick="showImageUpload(\'' . $name . '\', \'upload\', \'' . $width . '\', \'' . $height . '\', \'' . $size . '\')">本地上传</button>
            <button type="button" class="btn btn-default" onClick="showImageUpload(\'' . $name . '\', \'gallery\',\'' . $width . '\', \'' . $height . '\', \'' . $size . '\')">选择图库</button>
        </div>
    </div>';
    return $str;
}

function content_file($name, $content = '', $setting = '')
{
    $content = $content[0];
    $type = base64_encode($setting['type']);
    $size = (int) $setting['size'];
    return '<div class="input-group">
        <input type="text" class="form-control" size="50" value="' . $content . '" name="data[' . $name . ']" id="' . $name . '" placeholder="文件地址">
        <div class="input-group-btn">
            <button type="button" class="btn btn-default" onClick="admin.showFileUpload(\'' . $name . '\', \'upload\', \'' . $type . '\',\'' . $size . '\')">上传文件</button>
            <button type="button" class="btn btn-default" onClick="admin.showFileUpload(\'' . $name . '\', \'select\', \'' . $type . '\',\'' . $size . '\')">选择文件</button>
        </div>
    </div>';
}

function content_files($name, $content = '', $setting = '')
{
    $content = $content[0];
    $set = base64_encode($setting['type']) . '|' . (int) $setting['size'];
    $str = '<input type="hidden" class="form-control" value="' . $name . '" name="listfiles[]">
        <div id="list_' . $name . '_files"><div id="' . $name . '-sort-items">';
    if ($content) {
        $content = string2array($content);
        $filepath = $content['file'];
        $filename = $content['alt'];
        if (is_array($filepath) && !empty($filepath)) {
            foreach ($filepath as $id => $path) {
                $alt = isset($filename[$id]) ? $filename[$id] : '';
                $str .= '<p id="files_999' . $id . '">';
                $str .= '<input type="text" class="form-control" style="width: 100px;" value="' . $alt . '" name="data[' . $name . '][alt][]" placeholder="图片说明">';
                $str .= '<input type="text" class="form-control" style="width: 300px;" value="' . $path . '" name="data[' . $name . '][file][]" placeholder="图片地址">';
                $str .= '<button type="button" class="btn btn-default" onclick="admin.removeDIV(\'999' . $id . '\');">删除</button></p>';
            }
        }
    }
    $str .= '</div>
        <p>
            <button type="button" class="btn btn-default" onclick="admin.addNullFileLine(\'' . $name . '\')">添加地址</button>
            <button type="button" class="btn btn-default" onclick="admin.showFilesUpload(\'' . $name . '\',\'' . $set . '\')">批量上传</button>
        </p>
        <script>$("#' . $name . '-sort-items").sortable();</script>';
    return $str;
}

function content_date($name, $content = '', $setting = '')
{
    $c = $content[0];
    $type = isset($setting['type']) ? $setting['type'] : '%Y-%m-%d %H:%M:%S';
    $width = isset($setting['width']) ? $setting['width'] : 180;
    $str = '';
    if (!defined('CMS_DATE_LD')) {
        $str .= '
        <link href="/static/calendar/jscal2.css" type="text/css" rel="stylesheet">
        <link href="/static/calendar/border-radius.css" type="text/css" rel="stylesheet">
        <link href="/static/calendar/win2k.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="/static/calendar/calendar.js"></script>
        <script type="text/javascript" src="/static/calendar/cn.js"></script>';
        define('CMS_DATE_LD', 1); // 防止重复加载JS
    }
    return $str . '
    <input type="hidden" class="form-control" value="' . $c . '" name="data[' . $name . ']" id="date_' . $name . '">
    <input type="text" readonly="" class="form-control" style="min-width:' . $width . 'px;" value="' . ($c ? date(str_replace(array('%', 'M', 'S'), array('', 'i', 's'), $type), $c) : '') . '" id="' . $name . '" >
    <script type="text/javascript">
        Calendar.setup({
        weekNumbers : true,
        inputField  : "' . $name . '",
        trigger     : "' . $name . '",
        dateFormat  : "' . $type . '",
        showTime    : true,
        minuteStep  : 1,
        onSelect    : function() {
            this.hide();
            var time = $("#' . $name . '").val();
            var date = (new Date(Date.parse(time.replace(/-/g,"/")))).getTime() / 1000;
            $("#date_' . $name . '").val(date);
        }
        });
    </script>';
}

function content_merge($name, $content = '', $setting = '')
{

}
