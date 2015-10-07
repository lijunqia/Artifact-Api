<?php

/**
 * Class LPingYin
 */
class LPingYin
{
	/**
	 * 汉字转拼音
	 * @param string $str 待转换的字符串
	 * @param string $charset 字符串编码
	 * @param bool $ishead 是否只提取首字母
	 * @return string 返回结果
	 */
	public static function get($str, $charset="utf-8", $ishead = 0)
	{
		$restr = '';
		$str = trim($str);
		//echo $str.'-';
		if($charset=="utf-8"){
			$str=iconv("utf-8","gb2312",$str);
		}
		$slen = strlen($str);
		$pinyins=array();
		if ($slen < 2) {
			return $str;
		}
		if(!file_exists(dirname(__FILE__).'/encoding/pinyin.dat'))
		{
			return $str;
		}
		$fp = fopen(dirname(__FILE__).'/encoding/pinyin.dat', 'r');
		while (!feof($fp)) {
			$line = trim(fgets($fp));
			$pinyins[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
		}

		fclose($fp);
		count($pinyins);
		for ($i = 0; $i < $slen; $i++) {
			if (ord($str[$i]) > 0x80) {
				$c = $str[$i] . $str[$i + 1];
				$i++;
				if (isset($pinyins[$c])) {
					if ($ishead == 0) {
						$restr .= $pinyins[$c];
					} else {
						$restr .= $pinyins[$c][0];
					}
				} else {
					$restr .= ",";
				}
			} else if (preg_match("/[a-z0-9]/i", $str[$i])) {
				$restr .= $str[$i];
			} else {
				$restr .= "_";
			}
		}
		return $restr;
	}

}