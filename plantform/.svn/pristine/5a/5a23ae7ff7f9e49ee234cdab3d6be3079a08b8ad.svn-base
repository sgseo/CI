<?php
/**
 * restful接口统一返回值
 * 响应response : {code:0, msg:未知错误, data:''}
 */
class response{
	
    static $format = 'json';
    static $debug = false;
    static $error = array();
    static $code_error = array();
    
    public  function __construct(){
    	require_once(_LIB_ROOT . 'config/config.code.php');
    	self::$code_error = $GLOBALS['G_NOTE'];
    }

    /**
     * @param $data
     * @return string
     */
    public static function to_xml($data){
        $xml = '';
        foreach($data as $key=>$val) {
            is_numeric($key)&&$key='item';
            $xml.="<$key>";
            $xml.=is_array($val)?self::to_xml($val): htmlspecialchars($val);
            $xml.="</$key>";
        }
        return $xml;
    }

    // 输出数据
    public static function render($result = array(), $format = 'json'){
        header("Content-type: text/html; charset=utf-8");
        //$result = empty($result)  ? array() : $result;
        $data = array_merge(self::get_error(), array('data' => $result));
        // 调试输出
        if(isset($_REQUEST['debug']) || self::$debug == true) {
        	echo '<pre>';
            echo print_r($data);
            exit;
        }

        // 格式化数据
        if((isset($_REQUEST['format']) && $_REQUEST['format'] == 'xml') || $format == 'xml') {
            $pre = '<?xml version="1.0" encoding="UTF-8"?>';
            echo $pre . self::to_xml($data);
        } else {
            echo json_encode($data, true);
        }
        exit;
    }

    // 设置错误码
    public static function set_error($code = 1, $msg = ''){
        self::$error = self::code_to_msg($code, $msg);
        return false;
    }

    // 获取错误码
    public static function get_error() {
        if(empty(self::$error)) {
            return self::code_to_msg(0);
        }
        return self::$error;
    }

    public static function code_to_msg($code = 1, $msg = ''){
         return array('code' => $code, 'msg' =>  self::$code_error[$code]?  self::$code_error[$code] : $msg );
    }

    // 打印调试
    public static  function myprint(){
        $num = func_num_args();
        $arg = func_get_args();
        echo '<pre>';
        $num == 0 ? print_r(debug_backtrace()) : ($num ==1 ? print_r($arg[0]) : var_dump($arg[0]) );
        die;
    }


}