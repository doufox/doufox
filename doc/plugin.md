# 插件

插件结构，

确保文件夹和入口文件名一样，如 tips/tips.php

利用钩子函数添加
addHookAction('admin_head', 'tips_css');
addHookAction('admin_index_header', 'tips');


钩子的埋入点函数
doHookAction

