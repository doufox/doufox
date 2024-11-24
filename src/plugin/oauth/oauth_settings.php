<h4>快捷登录（聚合登录）</h4>
<hr />
<div class="alert alert-info">此处设置的是本站用户登录的时候使用的快捷登录，需要先设置并开启对应的登录接口。<a href="https://u-id.cn" target="_blank"> 申请聚合登录 </a></div>
<table class="table_form">
    <tr>
        <th>应用接口地址</th>
        <td>
            <input class="form-control" type="text" size="50" placeholder="必须以 http(s)://开头并以/结尾，填错会导致无法回调" name="settings[oauth_url]" value="<?php echo $settings['oauth_url']; ?>" />
        </td>
    </tr>
    <tr>
        <th>应用AppId</th>
        <td>
            <input class="form-control" type="text" size="50" placeholder="应用AppId" name="settings[oauth_appid]" value="<?php echo $settings['oauth_appid']; ?>" />
        </td>
    </tr>
    <tr>
        <th>应用AppKey</th>
        <td>
            <input class="form-control" type="text" size="50" placeholder="应用AppKey" name="settings[oauth_appkey]" value="<?php echo $settings['oauth_appkey']; ?>" />
        </td>
    </tr>
    <tr>
        <th>微信快捷登录</th>
        <td>
            <select class="form-control" name="settings[oauth_wx]" default="<?php echo $settings['oauth_wx']; ?>">
                <option value="0" <?php if ($settings['oauth_wx'] == 0) echo ' selected'; ?>>关闭</option>
                <option value="1" <?php if ($settings['oauth_wx'] == 1) echo ' selected'; ?>>开启</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>QQ快捷登录</th>
        <td>
            <select class="form-control" name="settings[oauth_qq]" default="<?php echo $settings['oauth_qq']; ?>">
                <option value="0" <?php if ($settings['oauth_qq'] == 0) echo ' selected'; ?>>关闭</option>
                <option value="1" <?php if ($settings['oauth_qq'] == 1) echo ' selected'; ?>>开启</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>支付宝快捷登录</th>
        <td>
            <select class="form-control" name="settings[oauth_alipay]" default="<?php echo $settings['oauth_alipay']; ?>">
                <option value="0" <?php if ($settings['oauth_alipay'] == 0) echo ' selected'; ?>>关闭</option>
                <option value="1" <?php if ($settings['oauth_alipay'] == 1) echo ' selected'; ?>>开启</option>
            </select>
        </td>
    </tr>
</table>
