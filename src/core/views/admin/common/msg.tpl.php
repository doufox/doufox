<?php if (!empty($msg)) {?>
<div class="container-fluid">
    <div class="alert alert-dismissible alert-success text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
        <strong><?php echo $msg; ?></strong>
    </div>
</div>
<?php }
