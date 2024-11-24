<?php


/**
 * 获取 OAuth2.0 跳转登录地址
 * @param mixed $redirect_uri 返回地址
 * @param string $type 登录方式
 * @return string 登录地址
 */
function plugin_oauth_get_url($redirect_uri, $type = 'qq')
{
    global $conf;
    $state = md5(uniqid() . mt_rand());
    $_SESSION['state'] = $state;
    $param = [
        'act' => 'login',
        'appid' => $conf['oauth_appid'],
        'appkey' => $conf['oauth_appkey'],
        'type' => $type,
        'state' => $state,
        'redirect_uri' => $redirect_uri
    ];
    $url = $conf['oauth_url'] . 'connect.php?' . http_build_query($param);
    $output = get_curl($url);
    $res = json_decode($output, true);
    if ($res['code'] == 0 && isset($res['url'])) {
        return $res['url'];
    } else {
        return 0;
    }
}

/**
 * 通过 Authorization Code 获取用户信息
 * @param mixed $code 返回地址
 * @param string $type 登录方式
 * @return array|int 用户信息
 */
function plugin_oauth_get_userinfo($code, $type = 'qq')
{
    global $conf;
    $param = [
        'act' => 'callback',
        'appid' => $conf['oauth_appid'],
        'appkey' => $conf['oauth_appkey'],
        'type' => $type,
        'code' => $code
    ];
    $url = $conf['oauth_url'] . 'connect.php?' . http_build_query($param);
    $output = get_curl($url);
    $res = json_decode($output, true);
    if ($res['code'] == 0) {
        return $res;
    } else {
        return 0;
    }
}

function plugin_oauth_init() {
    $mod = 'user';
    $act = $_GET['act'];

    $notLogin = $act == 'login';

    if ($act == 'bind') {
        // 绑定第三方
        $back_url = $site_url . '/user/';
    } else if ($act == 'unbind') {
        // 解绑
        $back_url = $site_url . '/user/';
    } else if ($act == 'login') {
        // 第三方登录
        $back_url = $site_url . '/user/login.php';
    } else {
        // Tips::error('参数错误', $site_url);
        $this->show_message('参数错误', 2);
        // $this->show_message('参数错误', 1, url('admin/database/index', array('action' => 1, 'size' => $size)));
    }

    require_once PATH_PLUGIN . 'oauth' . DS . 'lib.php';

    $type = $_GET['type'];
    $redirect_url = $site_url . "/user/oauth.php?act={$act}&type={$type}";

    if ($type == 'qq') {
        if (!$conf['oauth_qq']) Tips::error('QQ登录未开启', $back_url);
        $type_name = 'QQ';
    } else if ($type == 'wx') {
        if (!$conf['oauth_wx']) Tips::error('微信登录未开启', $back_url);
        $type_name = '微信';
    } else if ($type == 'alipay') {
        if (!$conf['oauth_alipay']) Tips::error('支付宝登录未开启', $back_url);
        $type_name = '支付宝';
    } else if ($type == 'weibo') {
        if (!$conf['oauth_weibo']) Tips::error('微博登录未开启', $back_url);
        $type_name = '微博';
    }

    if ($act == 'unbind') {
        // 解除绑定
        if (!$userClass->set_social_uid($type, '')) {
            // 解除失败
            Tips::error('解除绑定失败', $back_url);
        }
        Tips::success('解除成功', $site_url . '/user/', 500);
    } else if (isset($_GET['code'])) {
        // 用 code 获取第三方用户信息，进行绑定
        $code = $_GET['code'];
        $state = $_GET['state'];

        if ($state != $_SESSION['state']) {
            unset($_SESSION['state']);
            Tips::error('Key验证失败', $back_url);
        }
        $userinfo = plugin_oauth_get_userinfo($code, $type);
        if (!isset($userinfo) || !isset($userinfo['social_uid'])) {
            Tips::error('第三方用户信息异常', $back_url);
        }
        if ($act == 'bind') {
            // 绑定第三方用户信息
            if (!$userClass->set_social_uid($type, $userinfo['social_uid'])) {
                // 绑定失败
                $userData = $userClass->has_social_uid($type, $userinfo['social_uid']);
                if (!empty($userData)) {
                    // 系统内查到已存在绑定信息
                    Tips::error("该{$type_name}已绑定过，请先解绑。", $back_url);
                } else {
                    Tips::error('绑定失败', $back_url);
                }
            }

            unset($_SESSION['state']);
            Tips::success('绑定成功', $site_url . '/user/', 500);
        } else if ($act == 'login') {
            // 查找系统内是否存在绑定信息
            $userData = $userClass->has_social_uid($type, $userinfo['social_uid']);
            if (empty($userData)) Tips::error("该{$type_name}未绑定账号，请先绑定。", $back_url);

            $userName = $userData['userName'];

            unset($_SESSION['state']);
            $userClass->Login($userName);
            Tips::success('登录成功', $site_url . '/user/', 500);
        }
    } else if (isset($_GET['type'])) {
        // 跳转到第三方获取授权 code
        $type = $_GET['type'];
        $url = plugin_oauth_get_url($redirect_url, $type);
        if (isset($url)) {
            header('Location:' . $url);
        } else {
            Tips::error('第三方登录异常', $back_url);
        }
    }

}


function plugin_oauth_render() {
    global $plugin_oauth_setting;
    if (isset($plugin_oauth_setting)) {
        $txt = '';
        if ($plugin_oauth_setting['oauth_qq'] == 1) {
            $txt .= '<a class="btn btn-link" href="' . url('admin/plugin/do', ['mod' => 'oauth', 'act' => 'login', 'type' => 'qq']) . '" title="QQ登录">ＱＱ</a>';
        }
        if ($plugin_oauth_setting['oauth_wx'] == 1) {
            $txt .= '<a class="btn btn-link" href="' . url('admin/plugin/do', ['mod' => 'oauth', 'act' => 'login', 'type' => 'weixin']) . '" title="微信登录">微信</a>';
        }
        if ($plugin_oauth_setting['oauth_alipay'] == 1) {
            $txt .= '<a class="btn btn-link" href="' . url('admin/plugin/do', ['mod' => 'oauth', 'act' => 'login', 'type' => 'alipay']) . '" title="支付宝登录">支付宝</a>';
        }
        if ($txt) {
            echo '<hr /><div class="row"><div class="col-md-12">快捷登录：' . $txt . '</div></div>';
        }
    }
}
