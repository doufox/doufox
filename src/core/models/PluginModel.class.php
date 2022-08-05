<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class PluginModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'id';
    }

    /**
     * 获取插件信息
     *
     * @param string $pluginFile
     * @return array
     */
    function get_plugin_info($pluginFile)
    {
        $pluginData = implode('', file(PATH_PLUGIN . $pluginFile));
        preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
        preg_match("/Version:(.*)/i", $pluginData, $version);
        preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
        preg_match("/Description:(.*)/i", $pluginData, $description);
        preg_match("/Author:(.*)/i", $pluginData, $author_name);
        preg_match("/Author URL:(.*)/i", $pluginData, $author_url);

        $active_plugins = Option::get('active_plugins');
        $ret = explode('/', $pluginFile);
        $plugin = $ret[0];
        $setting = (file_exists(PATH_PLUGIN . $plugin . '/' . $plugin . '_setting.php') && in_array($pluginFile, $active_plugins)) ? true : false;

        $plugin_name = isset($plugin_name[1]) ? strip_tags(trim($plugin_name[1])) : '';
        $version = isset($version[1]) ? strip_tags(trim($version[1])) : '';
        $description = isset($description[1]) ? strip_tags(trim($description[1])) : '';
        $plugin_url = isset($plugin_url[1]) ? strip_tags(trim($plugin_url[1])) : '';
        $author = isset($author_name[1]) ? strip_tags(trim($author_name[1])) : '';
        $author_url = isset($author_url[1]) ? strip_tags(trim($author_url[1])) : '';

        return array(
            'Name' => $plugin_name,
            'Version' => $version,
            'Description' => $description,
            'Url' => $plugin_url,
            'Author' => $author,
            'AuthorUrl' => $author_url,
            'Setting' => $setting,
            'Plugin' => $plugin,
        );
    }
}
