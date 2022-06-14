<?php
if (!defined('IN_CMS')) {
    exit();
}

class CategoryController extends API
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $catid = (int) $this->get('catid');
        $data = $this->category_cache; // 栏目缓存
        if ($catid && isset($data[$catid])) {
            // 指定栏目
            $this->response(200, $data[$catid], 'success');
        }
        // 全部栏目
        $data = array_values($data);
        $this->response(200, $data, 'success');
    }

    /**
     * 全部栏目
     */
    public function listAction()
    {
        $list = $this->category_cache; // 缓存
        // 读取数据库后台不会根据排序显示
        // $list = $this->category->findAll('catid,typeid,catpath,catname');
        $list = array_values($list);
        $this->response(200, $list, 'success');
    }

    /**
     * 栏目添加
     */
    public function addAction()
    {
        $this->response();
    }

    /**
     * 栏目删除
     */
    public function delAction()
    {
        $this->response();
    }

    /**
     * 栏目内容列表
     */
    public function contentsAction()
    {
        $list = $this->category_cache; // 读取文件缓存
        $catid = (int) $this->get('catid');
        if (!isset($catid)) {
            $this->response(403, NULL, 'Need Params catid');
        }
        if (!isset($list[$catid])) {
            $this->response(404, NULL, 'Not Found');
        }
        // 读取数据库后台不会根据排序显示
        // $list = $this->category->findAll('catid,typeid,catpath,catname');
        // $this->response(200, $list, 'success');

        $content_models = get_cache('contentmodel');
        $page_models = get_cache('pagemodel');
        $categorys = array();
        $result = $this->category->order('listorder ASC')->select();
        // 栏目类型
        $types = array(
            1 => '', // 内容模型
            2 => '', // 单页模型
            3 => '<font color="blue">外部链接</font>',
            4 => '<font color="green">独立单页</font>',
        );
        if (!empty($result)) {
            foreach ($result as $r) {
                $r['typename'] = $types[$r['typeid']]; // 栏目类型
                if ($r['typeid'] == 1) {
                    $r['typename'] = @$content_models[$r['modelid']]['modelname']; // 读取模型
                } else if ($r['typeid'] == 2) {
                    $r['typename'] = @$page_models[$r['modelid']]['modelname']; // 读取模型
                }

                $r['manage_edit'] = '<a href="' . url('admin/category/edit', array('catid' => $r['catid'])) . '">编辑</a>';
                $r['manage_add'] = '<a href="' . url('admin/category/add', array('catid' => $r['catid'])) . '" >添加子栏目</a>';
                $r['manage_del'] = '<a href="#" class="category-btn-delete" name="删除栏目" data-id="' . $r['catid'] . '" data-name="' . $r['catname'] . '">删除</a>';
                $r['isdisplay'] = $r['ismenu'] ? '是' : '<font color="blue">否</font>';
                $r['catname'] = "<a href='$r[url]' target='_blank'>" . $r['catname'] . "</a>";
                $r['manage_content'] = '<a href="' . url('admin/content/index', array('catid' => $r['catid'])) . '" >' . $r['items'] . '</a>';
                $categorys[$r['catid']] = $r;
            }
        }
        // $str = "
        // <tr>
        //     <td><input name='order_\$catid' type='text' size='1' value='\$listorder' class='input-text-c'></td>
        //     <td>\$catid</td>
        //     <td>\$spacer\$catname</td>
        //     <td>\$catpath</td>
        //     <td>\$typename</td>
        //     <td>\$manage_content</td>
        //     <td>\$isdisplay</td>
        //     <td>\$manage_edit \$manage_add \$manage_del</td>
        // </tr>";
        // include $this->views('admin/category/list');

    }
}
