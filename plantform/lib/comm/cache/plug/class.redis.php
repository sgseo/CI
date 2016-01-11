<?
/**
 * redis缓存
 */

class redis_Cache extends abstract_Cache {

    /**
     * Memcache 对像 
     * @var Object 
     */
    private $mObject = null;
		
	/**
	 * 析构
	 * 
	 * @param void
	 * @return void
	 */
	public function __construct() {

		//do Nothing
        $this->mObject = new Redis;
	}
	
	/**
	 * 初始化对像
	 * 
	 * @param mixed $setting 配置参数
	 * @return void
	 */
	public function init($cfg) {

        if (is_array($cfg)) {

            foreach($cfg as $item) {

                $this->mObject->pconnect($item['HOST'], $item['PORT']);
            }
        }
	}
	
	/**
	 * 获取数据
	 * 
	 * @param String $key 键值
	 * @return Mixed
	 */
	public function get($key) {

        $val = $this->mObject->get($key);
        $unserialize_val = unserialize($val);
        return $unserialize_val;
        if(is_array($unserialize_val)){
        
        	return $unserialize_val;
        }else{
        
        	return $val;
        }

		return $val;
	}
	
	/**
	 * 设置缓存数据
	 * 
	 * @param String $key 键值
	 * @param Mixed $value 要缓存的内容
	 * @param Integer $ttl 存活时间
	 * @return void
	 */
	public function set($key, $value, $ttl = CACHE_DEFAULT_EXP_TIME_REDIS) {
        
        $this->mObject->set($key, serialize($value), $ttl);
	}
	
	/**
	 * 删除指定Key的内容
	 * 
	 * @param String $key 
	 * @return void
	 */
	public function delete($key) {
		
        $this->mObject->delete($key);
	}
}