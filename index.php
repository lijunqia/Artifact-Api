<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
header("Content-type: text/html; charset=utf-8"); 

//域名设置
if(isset($_SERVER['HTTP_HOST']))
	$domain = strtolower($_SERVER['HTTP_HOST']);
else
	$domain = strtolower($_SERVER['SERVER_NAME']);

$arr = explode('.', $domain);
defined('D_PREFIX') or define('D_PREFIX',$arr[0]);//域名前缀
unset($arr[0]);
defined('D_SUFFIX') or define('D_SUFFIX','.'.join('.',$arr));
defined('D_DOMAIN') or define('D_DOMAIN',join('_',$arr));
//ini_set('session.cookie_domain', D_SUFFIX); 

// change the following paths if necessary
require_once(dirname(__FILE__).'/protected/config/config.php');
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(isset($_POST["SessionID"]))
{
	session_id($_POST["SessionID"]);
}
elseif(isset($_GET["SessionID"]))
{
	session_id($_GET["SessionID"]);
}

require_once(YII_LIB);
Yii::createWebApplication($config)->run();
