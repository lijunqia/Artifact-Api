<?php
//YII库配置
/* 取得当前站点所在的根目录 */
define('ROOT_PATH', str_replace('/protected/config/config.php', '', str_replace('\\', '/', __FILE__)));
define('YII_LIB',ROOT_PATH.'/../../weblib/yii/yii.php');
define('YII_DEBUG',true);//测试环境，生产环境可屏蔽
define('YII_TRACE_LEVEL',3);//输出日志等级

//数据库配置
define('DB_CONNECTION','mysql:host=localhost;dbname=soft_artifact');
define('DB_USER','soft');
define('DB_PASSWORD','UdJOiK2iDRalCGNe');
define('DB_EMULATE',true);
define('DB_CHARSET','utf8');

//MEMCACHE缓存配置，单服务器
define('MEMCACHE_HOST','localhost');//主机
define('MEMCACHE_PORT',11211);//端口
define('MEMCACHE_WEIGHT',100);//权重
define('MEMCACHE_TIMEOUT',3600);//超时

//sphinx缓存配置，单服务器
define('SPHINX_HOST','localhost');//主机
define('SPHINX_PORT',9312);//端口
define('SPHINX_TIMEOUT',3600);//超时
define('SPHINX_WEIGHT_NAME',10000);//权重
define('SPHINX_WEIGHT_KEY',100);//权重

//网站配置
define('SITE_UPLOAD',ROOT_PATH.'/upload');//上传目录
define('SITE_IP',ROOT_PATH.'/../../weblib/common/ip.dat');//IP库地址
