<?php

/**
 * 计算经纬度距离,百度坐标距离
 *
 * @author Jamez <9623595@qq.com>
 * @version $Id: Sms.php 2011-11-19 $
 * @package components
 * @since 1.0
 * @return 接口返回：<SendState><FailPhone/><State>1</State><Id>803741</Id></SendState>
 * @link http://sms.gknet.com.cn:8180/httphelp.htm
 */
class LDistance
{
    /**
     * 地球半径KM
     */
    const EARTH_RADIUS = 6378137;
    /**
     * 圆周率
     */
    const PI = 3.1415926535898;

    /**
     * @param $d
     *
     * @return float
     */
    public static function rad($d)
    {
        return $d * self::PI / 180.0;
    }

    /**
     * @param $point 点坐标(经,纬)数组array(lng,lat)
     * @param $point2 点坐标(经,纬)数组array(lng,lat)
     *
     * @return float|int 单位M
     */
    public static function distance($point, $point2)
    {
        if(!self::check($point) || !self::check($point2))return false;
        $lat1 = self::rad($point['lat']);
        $lat2 = self::rad($point2['lat']);
        $lng1 = self::rad($point['lng']);
        $lng2 = self::rad($point2['lng']);

        $a = $lat1 - $lat2;
        $b = $lng1 - $lng2;
        return 2 * asin(sqrt(pow(sin($a/2),2) + cos($lat1)*cos($lat2)*pow(sin($b/2),2))) * self::EARTH_RADIUS;
    }

    /**
     * 百度坐标转换成GPS坐标
     * @param $point 百度坐标(经,纬)数组array(lng,lat)
     *
     * @return string
     */
    public static function baidu2Gps($point)
    {
        if(!self::check($point))return false;
        $result = @file_get_contents("http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x={$point['lng']}&y={$point['$lat']}");
        $json = json_decode($result);
        if($json->error == 0)
        {
            $bx = base64_decode($json->x);
            $by = base64_decode($json->y);
            $GPS_x = 2 * $point['lng'] - $bx;
            $GPS_y = 2 * $point['lat'] - $by;
            return array('lng'=>$GPS_x, 'lat'=>$GPS_y);
        }
        else
            return $point;
    }

    /**
     * @param $point 点坐标(经,纬)数组array(lng,lat)
     *
     * @return bool
     */
    public static function check($point)
    {
        if(!isset($point['lng']) || !isset($point['lat']))
            return false;
        if(abs($point['lng'])>180 || abs($point['lat']>90))
            return false;
        return true;
    }

}