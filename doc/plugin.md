# 插件

插件结构，

确保文件夹和入口文件名一样，如 tips/tips.php

利用钩子函数添加

```
addHookAction('埋入点', '函数名');
addHookAction('admin_top', 'tips');
```

钩子的埋入点函数
doHookAction

可埋点位置：

```
admin_head                 - 管理界面头部 head 结束位置
admin_top                  - 管理界面头部
admin_footer               - 管理界面底部

admin_index_top            - 管理主界面首页头部
admin_index_bottom         - 管理主界面首页底部
admin_index_content_top    - 管理主界面首页内容区域头部
admin_index_content_bottom - 管理主界面首页内容区域底部


view_head                  - 网页头部 head 结束位置
view_footer                - 网页界面底部 body 前位置
```
