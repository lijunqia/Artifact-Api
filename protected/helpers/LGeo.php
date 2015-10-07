<?php

/**
 *  Encode and decode geohashes
 *  $geohash=new Geohash;
 *  //获取附近的信息
 * $n_latitude = $_GET['la'];
 * $n_longitude = $_GET['lo'];
 * //开始
 * $b_time = microtime(true);
 *  //当前 geohash值
 * $n_geohash = $geohash->encode($n_latitude,$n_longitude);
 * //附近
 * $n = $_GET['n'];
 * $like_geohash = substr($n_geohash, 0, $n);
 * $sql = 'select * from mb_shop_ext where geohash like "'.$like_geohash.'%"';
 * echo $sql;
 * $data = $mysql->queryAll($sql);
 * //算出实际距离
 * foreach($data as $key=>$val)
 * {
 * $distance = getDistance($n_latitude,$n_longitude,$val['latitude'],$val['longitude']);
 * $data[$key]['distance'] = $distance;
 * //排序列
 * $sortdistance[$key] = $distance;
 * }
 * //距离排序
 * array_multisort($sortdistance,SORT_ASC,$data);
 * //结束
 * $e_time = microtime(true);
 * echo $e_time - $b_time;
 * var_dump($data);
 */

class LGeo
{
    private $coding="0123456789bcdefghjkmnpqrstuvwxyz";
    private $codingMap=array();

    public function __construct()
    {
        for($i=0; $i<32; $i++)
        {
            $this->codingMap[substr($this->coding,$i,1)]=str_pad(decbin($i), 5, "0", STR_PAD_LEFT);
        }

    }

    /**
     * 根据GEOHASH解码为具体经纬度
     * @param $hash
     *
     * @return array $lat,$long
     */
    public function decode($hash)
    {
        $binary="";
        $hl=strlen($hash);
        for($i=0; $i<$hl; $i++)
        {
            $binary.=$this->codingMap[substr($hash,$i,1)];
        }

        $bl=strlen($binary);
        $blat="";
        $blong="";
        for ($i=0; $i<$bl; $i++)
        {
            if ($i%2)
                $blat=$blat.substr($binary,$i,1);
            else
                $blong=$blong.substr($binary,$i,1);

        }

        $lat=$this->binDecode($blat,-90,90);
        $long=$this->binDecode($blong,-180,180);

        $latErr=$this->calcError(strlen($blat),-90,90);
        $longErr=$this->calcError(strlen($blong),-180,180);

        $latPlaces=max(1, -round(log10($latErr))) - 1;
        $longPlaces=max(1, -round(log10($longErr))) - 1;

        $lat=round($lat, $latPlaces);
        $long=round($long, $longPlaces);

        return array($lat,$long);
    }

    /**
     * 根据经纬度编码为GEOHASH串
     * @param double $lat 纬度
     * @param double $long 经度
     *
     * @return string
     */
    public function encode($lat,$long)
    {
        $plat=$this->precision($lat);
        $latbits=1;
        $err=45;
        while($err>$plat)
        {
            $latbits++;
            $err/=2;
        }

        $plong=$this->precision($long);
        $longbits=1;
        $err=90;
        while($err>$plong)
        {
            $longbits++;
            $err/=2;
        }

        $bits=max($latbits,$longbits);

        $longbits=$bits;
        $latbits=$bits;
        $addlong=1;
        while (($longbits+$latbits)%5 != 0)
        {
            $longbits+=$addlong;
            $latbits+=!$addlong;
            $addlong=!$addlong;
        }


        $blat=$this->binEncode($lat,-90,90, $latbits);

        $blong=$this->binEncode($long,-180,180,$longbits);

        $binary="";
        $uselong=1;
        while (strlen($blat)+strlen($blong))
        {
            if ($uselong)
            {
                $binary=$binary.substr($blong,0,1);
                $blong=substr($blong,1);
            }
            else
            {
                $binary=$binary.substr($blat,0,1);
                $blat=substr($blat,1);
            }
            $uselong=!$uselong;
        }

        $hash="";
        for ($i=0; $i<strlen($binary); $i+=5)
        {
            $n=bindec(substr($binary,$i,5));
            $hash=$hash.$this->coding[$n];
        }


        return $hash;
    }

    private function calcError($bits,$min,$max)
    {
        $err=($max-$min)/2;
        while ($bits--)
            $err/=2;
        return $err;
    }

    private function precision($number)
    {
        $precision=0;
        $pt=strpos($number,'.');
        if ($pt!==false)
        {
            $precision=-(strlen($number)-$pt-1);
        }

        return pow(10,$precision)/2;
    }

    private function binEncode($number, $min, $max, $bitcount)
    {
        if ($bitcount==0)
            return "";
        $mid=($min+$max)/2;
        if ($number>$mid)
            return "1".$this->binEncode($number, $mid, $max,$bitcount-1);
        else
            return "0".$this->binEncode($number, $min, $mid,$bitcount-1);
    }

    private function binDecode($binary, $min, $max)
    {
        $mid=($min+$max)/2;

        if (strlen($binary)==0)
            return $mid;

        $bit=substr($binary,0,1);
        $binary=substr($binary,1);

        if ($bit==1)
            return $this->binDecode($binary, $mid, $max);
        else
            return $this->binDecode($binary, $min, $mid);
    }

    /**
     * 根据经纬度查询具体地址
     * @param double $lat 纬度
     * @param double $long 经度
     *
     * @return string
     */
    public function address($lat,$long)
    {
        $result = @file_get_contents("http://maps.google.cn/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=true&language=zh-CN");
        if(!$result)return '';
        $json = json_decode($result);
        if($json->status == 'OK')
        {
            return $json->results[0]->formatted_address;
        }
        else
            return '';
    }
}
