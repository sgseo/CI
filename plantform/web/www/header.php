<?php
//定义基类根目录
define('_PATH_SEPARATOR_TEMP', preg_match("/WIN/i",PHP_OS) ? "\\" : "/");
define('_LIB_ROOT' , dirname(dirname(dirname(__FILE__))) . _PATH_SEPARATOR_TEMP .'lib/');

//定义windows和Linux系统的路径链接符号差别
define('_PATH_SEPARATOR', preg_match("/WIN/i",PHP_OS) ? ";" : ":");

ini_set("include_path", "."._PATH_SEPARATOR._LIB_ROOT);

@chdir(dirname(__FILE__));
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

//包含核心类库
require_once(_LIB_ROOT . 'comm/core/class.core.php');
require_once(_LIB_ROOT.  'config/config.comm.php');
require_once(_LIB_ROOT . 'function/function.comm.php');
$application = core::Singleton("comm.application.wwwApplication");
$application->initialize();
$config = $application->getConfig();
