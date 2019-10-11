<?php


/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string)
{
    if (!is_array($string)) {
        return stripslashes($string);
    }

    foreach ($string as $key => $val) {
        $string[$key] = new_stripslashes($val);
    }

    return $string;
}
/**
 * 将字符串转换为数组
 * @param string $data 字符串
 * @return array 返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data)
{
    if ($data == '') {
        return array();
    }

    if (is_array($data)) {
        return $data;
    }

    if (strpos($data, 'array') !== false && strpos($data, 'array') === 0) {
        @eval("\$array = $data;");
        return $array;
    }
    return unserialize($data);
}

/**
 * 将数组转换为字符串
 * @param array $data 数组
 * @param bool $isformdata 如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return string 返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1)
{
    if ($data == '') {
        return '';
    }

    if ($isformdata) {
        $data = new_stripslashes($data);
    }

    return serialize($data);
}


// $aaa = 'a:1:{s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}';
// $setting = string2array($aaa);
// print_r($setting);

$form = array(
    'default' => array(
        'username' => array(
            'name' => '用户名',
            'show' => 1
        ),
        'listorder' => array(
            'name' => '排序编号',
            'show' => 1
        ),
        'status' => array(
            'name' => '状态',
            'show' => 1
        ),
        'time' => array(
            'name' => '提交时间',
            'show' => 1
        ),
        'ip' => array(
            'name' => 'IP地址',
            'show' => 1
        ),
    )
);

$member = array(
    'default' => array(
        'username' => array(
            'name' => '用户名',
            'show' => 1
        ),
        'nickname' => array(
            'name' => '用户昵称',
            'show' => 1
        ),
        'email' => array(
            'name' => '邮箱地址',
            'show' => 1
        ),
        'avatar' => array(
            'name' => '用户头像',
            'show' => 1
        ),
        'regdate' => array(
            'name' => '注册时间',
            'show' => 1
        ),
        'regip' => array(
            'name' => '注册IP',
            'show' => 1
        ),
        'status' => array(
            'name' => '用户状态',
            'show' => 1
        ),
    )
);
// print_r($arra);
print_r(array2string($member));
