<?php include $this->install_tpl("header");?>

<script type="text/javascript">
    function $(ID) {return document.getElementById(ID);}
    function test() {
        if($('db_host').value == '') {
            alert('请填写数据库服务器');
            $('db_host').focus();
            return;
        }
        $('tdb_host').value = $('db_host').value;

        if($('db_user').value == '') {
            alert('请填写数据库用户名');
            $('db_user').focus();
            return;
        }
        $('tdb_user').value = $('db_user').value;
        $('tdb_pass').value = $('db_pass').value;

        if($('db_name').value == '') {
            alert('请填写数据库名');
            $('db_name').focus();
            return;
        }
        $('tdb_name').value = $('db_name').value;

        if($('tb_pre').value == '') {
            alert('请填写数据表前缀');
            $('tb_pre').focus();
            return;
        }
        $('ttb_pre').value = $('tb_pre').value;
        $('db_form').submit();
    }
    function check() {
        if($('db_host').value == '') {
            alert('请填写数据库服务器');
            $('db_host').focus();
            return false;
        }

        if($('db_user').value == '') {
            alert('请填写数据库用户名');
            $('db_user').focus();
            return false;
        }

        if($('db_name').value == '') {
            alert('请填写数据库名');
            $('db_name').focus();
            return false;
        }

        if($('tb_pre').value == '') {
            alert('请填写数据表前缀');
            $('tb_pre').focus();
            return false;
        }

        if($('username').value.length < 5) {
            alert('后台帐号最少5位');
            $('username').focus();
            return false;
        }

        if(!$('username').value.match(/^[a-z0-9]+$/)) {
            alert('后台帐号只能使用小写字母(a-z)、数字(0-9)');
            $('username').focus();
            return false;
        }

        if($('password').value.length < 5) {
            alert('后台密码最少5位');
            $('password').focus();
            return false;
        }

        $('tip').style.display = '';
        $('submit').disabled = true;
        return true;
    }
    function testa () {
        $('ttb_test').value=0;
        test();
    }
    function testb () {
        $('ttb_test').value=1;
        test();
    }
</script>
<div class="panel-body">
    <p class="lead text-center">基础配置</p>
    <hr />
    <iframe id="db_tester" name="db_tester" style="display:none;"></iframe>
    <form action="" method="post" id="db_form" target="db_tester">
        <input type="hidden" name="step" value="db_test"/>
        <input type="hidden" name="tdb_host" id="tdb_host"/>
        <input type="hidden" name="tdb_user" id="tdb_user"/>
        <input type="hidden" name="tdb_pass" id="tdb_pass"/>
        <input type="hidden" name="tdb_name" id="tdb_name"/>
        <input type="hidden" name="ttb_pre"  id="ttb_pre"/>
        <input type="hidden" name="ttb_test" id="ttb_test"/>
    </form>
    <form class="form-horizontal" action="" method="post" id="dform" onsubmit="return check();">
        <input type="hidden" name="step" value="3">
        <?php if (!$error) {?>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_host">数据库主机：</label>
            <div class="col-sm-8">
                <input class="form-control" name="db_host" type="text" id="db_host" value="localhost" placeholder="数据库主机" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_user">数据库用户：</label>
            <div class="col-sm-8">
                <input class="form-control" name="db_user" type="text" id="db_user" value="" placeholder="数据库用户" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_pass">数据库密码：</label>
            <div class="col-sm-8">
                <input class="form-control" name="db_pass" type="text" id="db_pass" value="" placeholder="数据库密码" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="db_name">数据库名：</label>
            <div class="col-sm-8">
                <input class="form-control" name="db_name" type="text" id="db_name" value="" placeholder="数据库名" onblur="testa();" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="tb_pre">数据库表前缀：</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <input class="form-control" name="tb_pre" type="text" id="tb_pre" value="df_" placeholder="数据库表前缀" />
                    <div class="input-group-btn">
                        <button class="btn btn-default" onclick="testb();">测试连接</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="username">超级管理员帐号：</label>
            <div class="col-sm-8">
                <input class="form-control" name="username" type="text" id="username" value="admin" placeholder="超级管理员帐号" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="password">超级管理员密码：</label>
            <div class="col-sm-8">
                <input class="form-control" name="password" type="text" id="password" value="admin" placeholder="超级管理员密码" />
            </div>
        </div>
        <div class="form-group" id="tip" style="display:none">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">
                <div style="color:#060;font-weight: 700;" >安装中...<img src="/static/img/loading.gif"></div>
            </div>
        </div>
        <hr />
        <div class="text-center">
            <button class="btn btn-default" type="submit" name="submit" id="submit">安装</button>
        </div>
        <?php } else {?>
        <div class="install-status"><?php echo $error; ?></div>
        <?php } ;?>
    </form>
</div>

<?php include $this->install_tpl("footer");?>