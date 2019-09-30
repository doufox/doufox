<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Image Upload Result</title>
    <link type="text/css" href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <input name="filename" id="filename" type="hidden" value="<?php echo $data['filename']; ?>">
    <p><?php echo $data['msg']; ?></p>
    <p class="show-tips"><?php echo $note; ?></p>
</body>

</html>