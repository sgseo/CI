<?
/**
 * 缓存配置方案
 */

//定义缓存类型
define('_CAHCE_SYSTEM',		'memcache');

//默认缓存时间
define("CACHE_DEFAULT_EXP_TIME", 86400  );  //一天

$GLOBALS['MEMCACHE_CONFIG'] = array(
    //缺省服务器
    'WWW' => array(
        array('HOST' => '192.168.128.95', 'PORT' => 11211),
        array('HOST' => '192.168.128.95', 'PORT' => 11212),
        array('HOST' => '192.168.128.95', 'PORT' => 11213),
        array('HOST' => '192.168.128.95', 'PORT' => 11214),
        array('HOST' => '192.168.128.95', 'PORT' => 11215),
        array('HOST' => '192.168.128.95', 'PORT' => 11216),
        ),
    );


//定义缓存类型
define('_CAHCE_SYSTEM_TT',		'tt');

//默认缓存时间
define("CACHE_DEFAULT_EXP_TIME_TT", 1  );

$GLOBALS['TT_CONFIG'] = array(
		//缺省服务器
		'WWW' => array(
				array('HOST' => '192.168.128.108', 'PORT' => 11233),
		),
);

//定义缓存类型
define('_CAHCE_SYSTEM_REDIS',		'redis');

//默认缓存时间
define("CACHE_DEFAULT_EXP_TIME_REDIS", 0  );

$GLOBALS['REDIS_CONFIG'] = array(
		//缺省服务器
		'WWW' => array(
				array('HOST' => '127.0.0.1', 'PORT' => 6379),
		),
);
