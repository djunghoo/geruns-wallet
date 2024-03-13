<?php $part = isset($_SERVER['PATH_INFO']) ? explode('/', preg_replace('~^/?(.*?)/?
	$~', '$1', $_SERVER['PATH_INFO'])) : array();
$mod_co = count($part);
$web_file = 'app_modules/';
$web_folder = 'app_modules/';
$view = array(
	"home" => $web_folder . "/"
);
$page = array('login', 'logout');
