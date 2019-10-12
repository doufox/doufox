<?php

echo '<br/>'.microtime(true);
echo '<br/>'.$_SERVER['REQUEST_TIME'];
echo json_encode($_SERVER);
echo '<br/>$_GET=' . json_encode($_GET) . PHP_EOL;

$path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
echo '<br/>$path_url_string=' . $path_url_string . PHP_EOL;

parse_str($path_url_string, $url_info_array);
echo '<br/>$url_info_array=' . $url_info_array . PHP_EOL;

$_GET = array_merge($_GET, $url_info_array);
echo '<br/>$_GET=' . json_encode($_GET) . PHP_EOL;
