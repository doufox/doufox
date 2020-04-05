<?php include $this->admin_view('header');?>

<?php include $this->admin_view('navbar');?>
<?php include $this->admin_view('common/msg');?>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">快速导航</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/category/add'); ?>">添加栏目</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/index'); ?>">会员列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
                    <a class="list-group-item" href="<?php echo url('admin/attachment'); ?>">查看附件</a>
                    <a class="list-group-item" href="<?php echo url('admin/backup'); ?>">备份管理</a>
                    <a class="list-group-item" href="<?php echo url('admin/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">在线技术支持</div>
                        <div class="panel-body">
                            <p>社区支持：<a href="https://doufox.com/forum" target="_blank">社区支持</a><br />
                            联系QQ：1146171115<br />
                            E-mail：crogram@qq.com<br />
                            官方网站：<a href="https://doufox.com/" target="_blank">https://doufox.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="panel panel-default">
                            <div class="panel-heading">提交帮助请求(未实现)</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="inputEmail">邮箱：</label>
                                    <input type="text" class="form-control" id="inputEmail" name="data[email]" value="<?php echo $data['email']; ?>" placeholder="您的邮箱地址" />
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone">手机：</label>
                                    <input type="text" class="form-control" id="inputPhone" name="data[phone]" value="<?php echo $data['phone']; ?>" placeholder="您的手机号码" />
                                </div>
                                <div class="form-group">
                                    <label for="inputName">称呼：</label>
                                    <input type="text" class="form-control" id="inputName" name="data[name]" value="<?php echo $data['name']; ?>" placeholder="您的称呼" />
                                </div>
                                <div class="form-group">
                                    <label for="inputSubject">主题：</label>
                                    <input type="text" class="form-control" id="inputSubject" name="data[subject]" value="<?php echo $data['subject']; ?>" placeholder="主题" />
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">描述：</label>
                                    <textarea class="form-control" id="inputDescription" name="data[description]" value="<?php echo $data['description']; ?>" placeholder="问题描述"></textarea>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox">是否需要电话答复</label>
                                </div>
                                <hr />
                                <button type="submit" class="btn btn-default">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer');?>
