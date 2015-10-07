<?PHP
/**
 *
 * //调用方法:
 * $st = getTime();
 * $ip= '204.84.0.0';
 * $iploca = new IpLocation;
 * $iploca -> getIpLocation($ip);
 *  
 * $area['country'] = str_replace(array('CZ88.NET'), '', $iploca -> get('country'));
 * $area['area'] = str_replace(array('CZ88.NET'), '', $iploca -> get('area'));
 *  
 * $area['country']=='' && $area['country']='未知';
 * $area['area']=='' && $area['area']='未知';
 * $et=getTime();
 * echo 'time:'.($et-$st).'\r\n';
 * print_r($area);
 */

class LIpLocation
{
	protected $wrydat='';
	protected $fp='';
	protected $lastIp='';
	protected $ipNumber=0;

	public $country;
	public $area;
	
	function __construct()
	{
		$this->init();
	}
	
	function __destruct()
	{
		fclose($this->fp);
	}
	
	protected function init()
	{
		$this->wrydat = SITE_IP;
		if (!file_exists($this->wrydat))
			return;
		
		$this->fp = fopen($this->wrydat, 'rb');
		$this->getIpNumber();
//		$this->getWryVersion();
		
		$this->REDIRECT_MODE_0 = 0;
		$this->REDIRECT_MODE_1 = 1;
		$this->REDIRECT_MODE_2 = 2;
	}
	
	public function get($str)
	{
		return $this->$str;
	}
	
	protected function set($str,$val)
	{
		$this->$str = $val;
	}
	
	protected function getByte($length,$offset=null)
	{
		!is_null($offset) && fseek($this->fp, $offset, SEEK_SET);
		
		return fread($this->fp, $length);
	}
	
	protected function packIp($ip)
	{
		return pack('N', intval(ip2long($ip)));
	}
	
	protected function getLong($length=4, $offset=null)
	{
		$chr=null;
		for($c=0;$length%4!=0&&$c<(4-$length%4);$c++)
		{
			$chr .= chr(0);
		}
		$var = unpack( 'Vlong', $this->getByte($length, $offset).$chr);
		return $var['long'];
	}
	
	public function getWryVersion()
	{
		$length = preg_match("/coral/i",$this->wrydat)?26:30;
		$this->wrydatVersion = $this->getByte($length, $this->firstIp-$length);
		$this->wrydatVersion = iconv('GB2312', 'UTF-8', $this->wrydatVersion);
	}
	
	protected function getIpNumber()
	{
		$this->firstIp = $this->getLong();
		$this->lastIp = $this->getLong();
		$this->ipNumber = ($this->lastIp-$this->firstIp)/7+1;
	}
	
	protected function getString($data='', $offset=NULL)
	{
		$char = $this->getByte(1,$offset);
		while(ord($char) > 0)
		{
			$data .= $char;
			$char = $this->getByte(1);
		}
		
		return iconv('GB2312', 'UTF-8', str_replace(array('CZ88.NET'), '', $data));
	}
	
	protected function ipLocaltion($ip)
	{
		$ip = $this->packIp($ip);
		$low = 0;
		$high = $this->ipNumber-1;
		$ipPosition = $this->lastIp;
		while($low <= $high)
		{
			$t = floor(($low+$high)/2);
			if($ip < strrev($this->getByte(4,$this->firstIp+$t*7)))
				$high = $t - 1;
			else
			{
				if($ip > strrev($this->getByte(4,$this->getLong(3))))
					$low = $t + 1;
				else
				{
					$ipPosition = $this->firstIp+$t*7;
					break;
				}
			}
		}
		return $ipPosition;
	}
	
	protected function getArea()
	{
		$b = $this->getByte(1);
		switch(ord($b))
		{
			case $this -> REDIRECT_MODE_0 :
				return '';
				break;
			case $this -> REDIRECT_MODE_1:
			case $this -> REDIRECT_MODE_2:
				return $this->getString('',$this->getLong(3));
				break;
			default:
				return $this->getString($b);
				break;
		}
	}
	
	public function getIpLocation($ip)
	{
		$ippos = $this->ipLocaltion($ip);
		$this->ipRangeBegin = long2ip($this->getLong(4,$ippos));
		$this->ipRangeEnd = long2ip($this->getLong(4,$this->getLong(3)));
		$b = $this->getByte(1);
		switch(ord($b))
		{
			case $this -> REDIRECT_MODE_1:
				$b = $this->getByte(1,$this->getLong(3));
				if(ord($b) == $this -> REDIRECT_MODE_2)
				{
					$countryoffset = $this->getLong(3);
					$this->area = $this->getArea();
					$this->country = $this->getString('',$countryoffset);
				}
				else
				{
					$this->country = $this->getString($b);
					$this->area = $this->getArea();
				}
				break;
			case $this -> REDIRECT_MODE_2:
				$countryoffset = $this->getLong(3);
				$this->area = $this->getArea();
				$this->country = $this->getString('',$countryoffset);
				break;
			default:
				$this->country = $this->getString($b);
				$this->area   = $this->getArea();
				break;
		}
	}
}
