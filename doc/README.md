# 内容模型自定义字段的调用


在内容模型添加的自定义字段如 abc，可能会调用的地方如下：

1. list标签调用

    只需要在list标签内添加参数 optional=1 或者optional=true，就可以在list标签内调用自定义字段

    加上参数 optional 标志将会对自定义字段进行取值存储，如不显示自定义字段就不要添加

    ```
    {list catid=1 num=10 optional=true}
    　　{$vdata[abc]}
    {/list}
    ```

2. 内容展示模板页调用

    和内置字段使用方式一致，直接使用变量 {$abc} 即可
