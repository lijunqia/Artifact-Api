<?php
/**
 * LUtil class file.
 *
 * @author Jamez <9623595@qq.com>
 * @link http://www.35city.cn
 * @copyright Copyright &copy; 2011-2011 jamez
 * @license http://www.35city.cn/api/license
 */

/**
 * 工具集
 *
 * @author Jamez <9623595@qq.com>
 * @version $Id: AdCall.php 2011-11-19 $
 * @package components
 * @since 1.0
 */
class LUtil
{
	/**
	 * @return mixed
	 */
	public static function getIP()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
			$realip = $_SERVER['HTTP_X_REAL_IP'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$realip = $_SERVER['REMOTE_ADDR'];
		}
		return $realip;
	}

	/**
	 * 验证身份证
	 * @param string $card 号码
	 * @return boolean
	 */
	public static function guid() 
	{
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
					.substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12)
					.chr(125);// "}"
			return $uuid;
		}
	}


	/**
	 * 验证身份证
	 * @param string $card 号码
	 * @return boolean
	 */
	public static function isIDCard($card)
	{
		$patrn="/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/";
		
		return preg_match($patrn,$card) ;
	}
	
	/**
	 * 创建文件夹
	 * @param string $upfile 读取图像上传域,并使用系统上传组件上传
	 * @param string $path 存放文件夹名称,如wing
	 * @return array
	 */
	public static function upfile($upfile, $path)
	{
		$data = array('dir'=>'','file'=>'','url'=>'','title'=>'','type'=>'','size'=>'');
	    $tmpFile = CUploadedFile::getInstanceByName($upfile);//读取图像上传域,并使用系统上传组件上传
	    if(is_object($tmpFile) && get_class($tmpFile)==='CUploadedFile')
		{
			//创建文件存放路径
			$path = '/'.$path.'/'.date('Ym').'/';
            $filename               = 'app_'.date("His").floor(microtime() * 1000).'_'.LUtil::generateRandCode(4,4). '.' . $tmpFile->extensionName;//上传文件的扩展名

            $data['dir']    		= SITE_UPLOAD. $path ;   //重新赋值
			self::mkdirs($data['dir']);
            $data['url']    		= Yii::app()->request->hostInfo . Yii::app()->params->upload. $path . $filename;      //重新赋值
            $data['file']   		= $path .$filename ;               //文件名称
            $data['title']       	= $tmpFile->name;                       //文件标题        
            $data['type']   		= $tmpFile->type;                       //文件类型  
            $data['size']   		= $tmpFile->size;                       //文件大小  

            $tmpFile->saveAs($data['dir'] . $filename);//保存到服务器
        }
		
		return $data;
	}
	/**
	 * 创建文件夹
	 * @param string $s dir
	 * @return boolean
	 */
	public static function mkdirs($dir, $mode = 0777)
	{
		if (is_dir($dir) || @mkdir($dir, $mode)) 
			return TRUE;
		if (!self::mkdirs(dirname($dir), $mode)) return FALSE;
			return @mkdir($dir, $mode);
//		return is_dir($dir) or (self::mkdirs(dirname($dir), $mode) and mkdir($dir, $mode));  
	}
	/**
	 * 将XML转为数组 
	 * @data xml
	 * @return boolean
	 */
	public static function xml2Array($data){
		return json_decode(json_encode(simplexml_load_string($data)),TRUE);
	}
	
	/**
	 * 验证URL地址
	 * @param string $s URL
	 * @return boolean
	 */
	public static function isUrl($s) 
	{ 
		return preg_match('/^http[s]?:\/\/'. 
			'(([0-9]{1,3}\.){3}[0-9]{1,3}'. // IP形式的URL- 199.194.52.184 
			'|'. // 允许IP和DOMAIN（域名） 
			'([0-9a-z_!~*\'()-]+\.)*'. // 三级域验证- www. 
			'([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.'. // 二级域验证 
			'[a-z]{2,6})'.  // 顶级域验证.com or .museum 
			'(:[0-9]{1,4})?'.  // 端口- :80 
			'((\/\?)|'.  // 如果含有文件对文件部分进行校验 
			'(\/[0-9a-zA-Z_!~\*\'\(\)\.;\?:@&=\+\$,%#-\/]*)?)$/', 
			$s) == 1; 
	}
	/**
	 * 发送GET/POST
	 * @param string $url 发送地址
	 * @return string the encoded data
	 */
	public static function curl($url)
	{
		if(empty($url))return '';
		$ch = curl_init();
		$timeout = 10; 
		curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}

	/**
	 * 转换为时长:0.3元/分钟
	 * @param decimal $money
	 * @return int
	 */
	public static function toTime($money)
	{
		return strval(intval($money/0.5));
	}

	/**
	 * 转换为金额:0.3元/分钟
	 * @param decimal $time 时长
	 * @return int
	 */
	public static function toMoney($time)
	{
		return floatval($time*0.5);
	}
	
	/**
	 * 加密字符串
	 * @param string $string
	 * @return string
	 */
	public static function encrypt($string) 
	{
		return strtr(base64_encode(addslashes(gzcompress(serialize($string),9))), '+/=', '-_,');
	}

	/**
	 * 解密字符串
	 * @param string $string
	 * @return string
	 */
	public static function decrypt($string) 
	{
		return unserialize(gzuncompress(stripslashes(base64_decode(strtr($string, '-_,', '+/=')))));
	}

	/**
	 * 固定长度字符串的截取
	 * @param string $content 字符串
	 * @return int
	 */
	public static function substrs($content,$length,$str="...")
	{
		$content = strip_tags(trim($content));
//		$content = htmlspecialchars($content);
		if($length && strlen($content)>$length){
			if(strtolower(Yii::app()->charset)!='utf-8'){
				$retstr='';
				for($i = 0; $i < $length - 2; $i++) {
					$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
				}
				return $retstr.$str;
			}else{
				return self::utf8Trim(substr($content,0,$length)).$str;
			}
		}
		return $content;
	}
	public static function utf8Trim($str) {
		$len = strlen($str);
		$hex = '';
		for($i=strlen($str)-1;$i>=0;$i-=1){
			$hex .= ' '.ord($str[$i]);
			$ch   = ord($str[$i]);
			if(($ch & 128)==0)	return substr($str,0,$i);
			if(($ch & 192)==192)return substr($str,0,$i);
		}
		return($str.$hex);
	}

	/**
	 * GBK转为UTF-8
	 * @param string $string
	 * @return boolean
	 */
	public static function toUtf8($string) {
		try
		{
			return iconv("GBK","utf-8//IGNORE",$string);
		}
		catch(Exception $ex)
		{return $string;}
	}
	/**
	 * UTF-8转为GBK
	 * @param string $string
	 * @return boolean
	 */
	public static function toGbk($string) {
		try
		{
			return iconv("utf-8","GBK//IGNORE",$string);
		}
		catch(Exception $ex)
		{return $string;}
	}
	/**
	 * 判断字符串编码类型
	 * @param string $string
	 * @return boolean
	 */
	public static function isUtf8($string) {
		/*
		//方式一
		if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$string) == true) 
		{ 
			return true; 
		} else { 
			return false; 
		}
		*/
		//方式二，比较好点
		return preg_match('%^(?:
			  [\x09\x0A\x0D\x20-\x7E]            # ASCII
			| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
			|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
			|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
			|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		)*$%xs', $string);
		
	}
	
	/**
	 * 验证电话号码
	 * @param string $phone 电话号码
	 * @return boolean
	 */
	public static function isPhone($phone)
	{
		$patrn="/(^0\d{2,3}\d{7,8}$)|(^0?1(3|4|5|8)\d{9}$)/";
		
		return preg_match($patrn,$phone) ;
	}
	
	/**
	 * 验证手机号码
	 * @param string $phone 电话号码
	 * @return boolean
	 */
	public static function isMobile($phone)
	{
		return preg_match("/^1(3|4|5|8)\d{9}$/", $phone);
	}

	/**
	 * 格式化手机号码
	 * @param string $phone 电话号码
	 * @return string
	 */
	public static function formatMobile($phone)
	{
		$phone=self::formatPhone(trim($phone));
		if(substr($phone,0,1)=='0')
			$phone = substr($phone,1,12);
		if(!self::isMobile(trim($phone)))
			return "";
		return $phone;
		
	}	
	
	/**
	 * 格式化电话号码
	 * @param string $phone 电话号码
	 * @return string
	 */
	public static function formatPhone($phone)
	{
		if(strlen($phone)>10)
		{
			$pos=strpos($phone,'/');
			if(strlen($pos))
				$phone = trim(substr($phone,0,$pos));
				
			//去掉86
			$pos=strpos($phone,'+86-');
			if(strlen($pos))
				$phone=str_replace('+86-','',$phone);

			$pos=strpos($phone,'+86');
			print_r($pos);
			if(strlen($pos))
				$phone=str_replace('+86','',$phone);

			$pos=strpos($phone,'86-');
			if(strlen($pos))
				$phone=str_replace('86-','',$phone);

			$pre=substr($phone,0,2);
			if($pre == '86')
				$phone=substr($phone,2,strlen($phone));

			if(strlen($phone)>10)
			{
				$pos=strpos($phone,'-',6);
				if(strlen($pos))
					$phone = trim(substr($phone,0,$pos));
			}
		}
		$phone = str_replace('-','',$phone);
		if(!self::isPhone(trim($phone)))
			return "";
		return $phone;
		
	}
	/**
	 * 验证ADCALL号码
	 * @param string $no ADCALL号码
	 * @return boolean
	 */
	public static function isAdCall($no)
	{
		$patrn="/\d{10}$/";
		
		return preg_match($patrn,$no) ;
	}
	
	/**
	 * 生成随机数字
	 * @param int $min 最小位数
	 * @param int $max 最大位数
	 * @return string
	 */
	public static function generateRandCode($minLength=4, $maxLength=6)
	{
		if($minLength < 3)
			$minLength = 3;
		if($maxLength > 20)
			$maxLength = 20;
		if($minLength > $maxLength)
			$maxLength = $minLength;
		$length = mt_rand($minLength,$maxLength);

		$letters = '1478926';
		$vowels = '503';
//		$letters = 'bcdfghjklmnpqrstvwxyz';
//		$vowels = 'aeiou';
		$code = '';
		for($i = 0; $i < $length; ++$i)
		{
			if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
				$code.=$vowels[mt_rand(0,2)];
			else
				$code.=$letters[mt_rand(0,6)];
		}

		return $code;
	}
} 