# 模板标签使用说明

> 基本变量标签

```
{$site_title}       // 网页标题
{$site_keywords}    // 网页关键字
{$site_description} // 网页描述

{$site_url}        // 网站的网址
{$site_name}       // 网站的名称
{$site_template}   // 网站的主题
```

> template - 包含模板文件，将对应的模板文件内容渲染在调用的地方

使用方法

```
{template header.html} // 加载当前模板根目录下 header.html 模板文件
{template member/index.html} // 加载当前模板目录下的 member 目录里的 index.html 模板文件
```

> if - 条件判断


> list - 列表
>
> 只需要在 list 标签内添加参数 optional=1 或者 optional=true，就可以在 list 标签内调用自定义字段

在内容模型添加的自定义字段如 abc，可能会调用的地方如下：
加上参数 optional 标志将会对自定义字段进行取值存储，如不显示自定义字段就不要添加

```
{list catid=1 num=10 optional=true}
　　{$vdata[abc]}
{/list}
```
