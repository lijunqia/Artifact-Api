<?php
/**
 * ADCALL helper class file.
 *
 * @author Jamez <9623595@qq.com>
 * @link http://www.365.vc
 * @copyright Copyright &copy; 2011-2011 jamez
 * @license http://www.365.vc/api/license
 */

/**
 * ADCALL 呼叫助手
 *
 * @author Jamez <9623595@qq.com>
 * @version $Id: LCall.php 2011-11-19 $
 * @package components
 * @since 1.0
 */

class LCall
{
	public static function model()
	{
		return new self;
	}

	/**
	 * 发起语音
	 * @param array $params data to be encoded
	 *		- mobile : string 绑定手机
	 *		- type : int 0免费，1收费
	 *		- text : string 语音内容
	 * @return array
	 Array
(
    [Status] => 11
)
	 */
	public function speech($params)
	{
	    if(!isset($params['text']) || !isset($params['mobile']) ||  !LUtil::isMobile($params['mobile']))
	    {
			return 1006;
	    }
		$adc = AdcallClass::model()->findByPk(5);
		if(!$adc || empty($adc->AdCallClassUrl) || empty($adc->AdCallClassSpeech))
			return 1006;

		$http = array(
			'query_type' 	=> 48,
			'adcall_no' 	=> $adc->AdCallClassSpeech,
			'guest_phone' 	=> $params['mobile'],
			'speech_text' 	=> $params['text'],
			'max_money' 	=> 0,
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 11;
		$http['user_phone'] 	= '';
		
		return $this->analyse ($http);
	}


	/**
	 * 号码充值
	 * @param array $params data to be encoded
	 *		- AdCallNo : string AdCall号码
	 *		- minute : int 充值分钟数
	 *		- max : decimal 最高充值金额
	 *		- typeId : decimal 充值类型
	 *		- type : int 呼叫类型,0免费，1收费
	 * @return boolean
	 */
	public function allot($params)
	{
	    if(!isset($params['AdCallNo']) || !LUtil::isAdCall($params['AdCallNo']))
	    {
			return 1006;
	    }

		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;
		//充值金额
		$money = (isset($params['minute']) && $adc->AdCallClassPrice>0)?intval($params['minute'])/$adc->AdCallClassPrice:0;
	    if($money<0.3)
	    {
			return 1014;
	    }

		$http = array(
			'query_type' 	=> 18,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> isset($params['AdCallNo2'])?floatval($params['AdCallNo2']):0,
			'money'			=> floatval($money),
			'max'			=> isset($params['max'])?floatval($params['max']):0,
		);
		$http['SendUrl'] 	= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] = 5;
		$http['LogTypeID'] 	= isset($params['typeId'])?$params['typeId']:5;//充值类型
		$ret = $this->analyse ($http);
		if(isset($ret['Status']) && $ret['Status'] == '11')
			$this->saveAllotLog($http, $ret);
		return $ret;
	}

	/**
	 * 开通号码
	 * @param array $params data to be encoded
	 *		- id : string 开通类型，adcallclass表ID
	 *		- mobile : string 绑定手机
	 *		- sms : int 是否开通短信提醒
	 *		- minute : int 充值分钟数
	 *		- nick : string 呢称
	 *		- corp : string 公司名
	 *		- address : string 地址
	 *		- email : string 邮箱
	 * @return array
	 */
	public function open($params)
	{
	    if(!isset($params['id']) || !isset($params['mobile']) ||  !LUtil::isMobile($params['mobile']))
	    {
			return 1006;
	    }

		$adc = AdcallClass::model()->findByPk(intval($params['id']));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;
		//充值金额
		$money = (isset($params['minute']) && $adc->AdCallClassPrice>0)?intval($params['minute'])/$adc->AdCallClassPrice:0;

		$http = array(
			'query_type' 	=> 16,
			'adcall_no' 	=> '',
			'phone_no' 		=> $params['mobile'],
			'phone_no2' 	=> $params['mobile'],
			'phone_no3' 	=> $params['mobile'],
			'nick'			=> LUtil::toGbk(!isset($params['nick'])?'':$params['nick']),
			'corp_name' 	=> LUtil::toGbk(!isset($params['corp'])?'':$params['corp']),
			'corporate_name'=> LUtil::toGbk(!isset($params['corp'])?'':$params['corp']),
			'address' 		=> LUtil::toGbk(!isset($params['address'])?'':$params['address']),
			'sms_active' 	=> isset($params['sms'])?intval($params['sms']):0,
			'catalog' 		=> !isset($params['group'])?'':$params['group'],
			'money' 		=> $money,
			'email' 		=> !isset($params['email'])?'':$params['email'],
			'web_url' 		=> urlencode($_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]),
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 1;
		$http['guest_phone'] 	= '';
		$http['user_phone'] 	= $params['mobile'];
		
		return $this->analyse ($http);
	}

	/**
	 * 发起呼叫
	 * @param array $params data to be encoded
	 *		- AdCallNo : string AdCall号码
	 *		- AdCallNo2 : string AdCall号码VIP
	 *		- mobile : string 绑定手机
	 *		- tel : string 呼叫的电话号码
	 *		- group : string 会员组ID
	 *		- type : int 0免费，1收费
	 * @return array
	 */
	public function send($params)
	{
	    if(!isset($params['AdCallNo']) || !isset($params['tel']) || !isset($params['mobile']) || !LUtil::isAdCall($params['AdCallNo']) || !LUtil::isMobile($params['mobile']) || !LUtil::isPhone($params['tel']))
	    {
			return 1006;
	    }
		if($params['mobile'] == $params['tel'])
			return 1020;

		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 44,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> !isset($params['AdCallNo2'])?'':$params['AdCallNo2'],
			'group_id'		=> !isset($params['group'])?'':$params['group'],
			'guest_phone' 	=> $params['mobile'],
			'user_phone' 	=> $params['tel'],
			'max_money' 	=> 0,
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 3;
		
		return $this->analyse ($http);
	}

	/**
	 * 发起回呼，呼叫商家
	 * @param array $params data to be encoded
	 *		- AdCallNo : string AdCall号码
	 *		- AdCallNo2 : string AdCall号码VIP
	 *		- mobile : string 绑定手机
	 *		- tel : string 呼叫的电话号码
	 *		- group : string 会员组ID
	 *		- type : int 0免费，1收费
	 * @return array
Array
(
    [Status] => 11
)
	 */
	public function callback($params)
	{
	    if(!isset($params['AdCallNo']) || !isset($params['mobile']) || !LUtil::isAdCall($params['AdCallNo']) || !LUtil::isPhone($params['mobile']))
	    {
			return 1006;
	    }
		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 1,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> '',
			'group_id'		=> !isset($params['group'])?'':$params['group'],
			'guest_phone' 	=> $params['mobile'],
			'user_phone' 	=> !isset($params['tel'])?'':$params['tel'],
			'max_money' 	=> 0,
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 2;
		
		return $this->analyse ($http);
	}

	/**
	 * 发送短信给指定手机
	 * @param array $params data to be encoded
	 *		- AdCallNo : string ADCALL
	 *		- mobile : string 绑定手机
	 *		- phone : string 商家电话
	 *		- msg : string 短信内容
	 *		- type : int 0免费，1收费
	 * @return array
	 Array
(
    [Status] => 11
)
	 */
	public function sms($params)
	{		
	    if(!isset($params['msg']) || !isset($params['mobile']) || !LUtil::isMobile($params['mobile']) || !isset($params['AdCallNo']) || !LUtil::isAdCall($params['AdCallNo']))
	    {
			return 1006;
	    }
		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 2,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> !isset($params['AdCallNo2'])?'':$params['AdCallNo2'],
			'tel' 			=> $params['tel'],
			'msg' 			=> $params['msg'],
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 3;
		$http['guest_phone'] 	= $params['mobile'];
		$http['user_phone'] 	= !isset($params['phone'])?'':$params['phone'];
		
		return $this->analyse ($http);
	}

	/**
	 * 使用商家账号，发送短信给会员
	 * @param array $params data to be encoded
	 *		- AdCallNo : string 商家ADCALL
	 *		- mobile : string 绑定手机
	 *		- phone : string 商家电话
	 *		- msg : string 短信内容
	 *		- type : int 0免费，1收费
	 * @return array
Array
(
    [Status] => 11
)
	 */
	public function bsms($params)
	{		
	    if(!isset($params['msg']) || !isset($params['mobile']) || !LUtil::isMobile($params['mobile']) || !isset($params['AdCallNo']) || !LUtil::isAdCall($params['AdCallNo']))
	    {
			return 1006;
	    }

		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 2,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> '',
			'tel' 			=> $params['mobile'],
			'msg' 			=> LUtil::toGbk($params['msg']),
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 3;
		$http['guest_phone'] 	= $params['mobile'];
		$http['user_phone'] 	= !isset($params['phone'])?'':$params['phone'];
		
		return $this->analyse ($http);
	}

	/**
	 * 获取余额
	 * @param array $params data to be encoded
	 *		- AdCallNo : AdCall号码
	 *		- type : int 0免费，1收费
	 * @return array
Array
(
    [Status] => 11
    [item] => Array
        (
            [sellid] => G0001
            [callno] => 9001001010
            [balance] => 320.2
        )

    [counter] => 1
)
	 */
	public function balance($params)
	{
		if( !isset($params['AdCallNo']) ||  !LUtil::isAdCall($params['AdCallNo']) )
			return 1006;
		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 43,
			'adcall_no' 	=> $params['AdCallNo'],
			'adcall_no2' 	=> !isset($params['AdCallNo2'])?'':$params['AdCallNo2'],
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 10;
		$http['guest_phone'] 	= '';
		$http['user_phone'] 	= !isset($params['mobile'])?'':$params['mobile'];
		$ret = $this->analyse ($http);
		$ret['item']['minute'] = 0;
		if($ret['Status']=='11')
			$ret['item']['minute'] = $adc->AdCallClassPrice?intval($ret['item']['balance']/$adc->AdCallClassPrice):0;
		return $ret;
	}
	
	/**
	 * 获取密码
	 * @param array $params data to be encoded
	 *		- AdCallNo : AdCall号码
	 *		- type : int 0免费，1收费
	 * @return array
	 Array
(
    [Status] => 11
    [callno] => 9001001010
    [callpasswd] => 123456
    [sellId] => G0001
    [state] => 1
    [active] => 1
)
	 */
	public function password($params)
	{
		if( !isset($params['AdCallNo']) ||  !LUtil::isAdCall($params['AdCallNo']) )
			return 1006;
		$adc = AdcallClass::load(array('no'=>$params['AdCallNo'], 'type'=>isset($params['type'])?$params['type']:0));
		if(!$adc || $adc->AdCallClassUrl=='')
			return 1006;

		$http = array(
			'query_type' 	=> 4,
			'type' 			=> 2,
			'adcall_no' 	=> $params['AdCallNo'],
		);
		$http['SendUrl'] 		= $this->buildQuery($adc->AdCallClassUrl, $http);
		$http['LogClassID'] 	= 10;
		$http['guest_phone'] 	= '';
		$http['user_phone'] 	= '';
		
		return $this->analyse ($http);
	}
	
	/**
	 * 生成发送地址
	 * @param array $params 发送参数
			- url : string 
			- params : array
	 * @return array 
	 */
	public function buildQuery($url, $params)
	{
		$params['session_id'] 	= time();
		$params['surl'] 		= $_SERVER['HTTP_HOST'];
		$params['client_ip'] 	= $_SERVER['REMOTE_ADDR'];
		return $url . '&' . http_build_query($params, null, '&');
	}
	
	/**
	 * 发送GET/POST
	 * @param string $url 发送地址
	 * @return array 
	 */
	public function analyse ($http)
	{
		$xmlstring = LUtil::curl($http['SendUrl']);
		if(empty($xmlstring))return 1001;
		$xml = simplexml_load_string($xmlstring);
		if(empty($xml))return 1001;
		$json = json_encode($xml);
		$ret = json_decode($json,TRUE);
		$this->saveLog ($http, $json);
		if(empty($ret))return 1001;
		return $ret;
	}
	
	/**
	 * 发送GET/POST
	 * @param string $params 传入参数
	 * @param string $ret 调用ADCALL接口返回
	 * @return string the encoded data
	 */
	public function saveLog ($params, $ret)
	{
		$log = new AdcallLog();
		$log->WingID = intval(Yii::app()->user->id);
		$log->BusinessID = isset($params['bid'])?intval($params['bid']):0;
		$log->MemberID = isset($params['mid'])?intval($params['mid']):0;
		$log->AdCallNo = $params['adcall_no'];
		$log->AdCallLogClassID = $params['LogClassID'];
		$log->GuestPhone = isset($params['guest_phone'])?$params['guest_phone']:'';
		$log->UserPhone = isset($params['user_phone'])?$params['user_phone']:'';
		$log->AdCallLogTarget = $params['SendUrl'];
		$log->AdCallLogResponse = $ret;
		return $log->save();
	}

	/**
	 * 发送GET/POST
	 * @param array $params 传入参数
	 * @param array $ret 返回参数
	 * @return boolean
	 */
	public function saveAllotLog ($params, $ret)
	{
		$member = $params['model'];
		$log = new AllotLog();
		$log->WingID = intval(Yii::app()->user->id);
		$log->BusinessID = isset($params['bid'])?intval($params['bid']):0;
		$log->MemberID = isset($params['mid'])?intval($params['mid']):0;
		$log->AdCallNo = isset($params['adcall_no'])?$params['adcall_no']:'';
		$log->AllotLogTypeID = $params['LogTypeID'];
		$log->AllotLogMoney = floatval($params['money']);
		$log->AllotLogAfterMoney = isset($ret['money'])?floatval($ret['money']):0;
		return $log->save();
	}

	/**
	 * 发送GET/POST
	 * @param string $url 发送地址
	 * @return string the encoded data
	 */
	public static function result ($ret,$type=0)
	{
		if($type == 1)
		{
			if($ret == 11110 || $ret == 11101 || $ret == 110)
				return '此商家专线号码已暂停，您可以联系其他同类商家。';
			return '当前预定人数过多，建议您直接拨打4006985985联系我的网客服人员。';
			
		}
		switch(intval($ret))
		{
			case 11:
				$msg='正在呼叫，请稍后！接听后，系统将为您接通对方电话本次通话不会在您所使用的手机上产生任何费用，请放心使用！';
				break;
			case 100:
				$msg='该号码不能进行电话回呼';
				break;
			case 110:
				$msg="该号码已停用";
				break;
			case 1110:
				$msg="本号码已加入黑名单";
				break;
			case 101:
				$msg='本IP不能进行回呼';
				break;
			case 111:
				$msg='本电话号码不久前回呼过，请梢后再呼';
				break;
			case 11001:
				$msg='回呼次数达到当天最高次数';
				break;
			case 11010:
				$msg='消费金额达到当前最高金额';
				break;
			case 1001:
				$msg='免费电话不在开放时间内.';
				break;
			case 1002:
				$msg='免费电话不在开放时间内.';
				break;
			case 1003:
				$msg='对不起，该地区不提供免费电话服务！';
				break;
			case 1004:
			case 1005:
			case 1006:
			case 1007:
				$msg='用户已锁定！';
				break;
			case 11110:
			case 11101:
				if($type == 1)
					$msg = '该商家电话余额不足，请更换其他同类商家';
				else
					$msg='您的时长已用完，请充值';
				break;
			case 200:
				$msg='请下载安装商友通软件后方能使用商友通拨打电话.';
				break;
			case 222:
				$msg='每天拨打时间已达上限，请明天再来，谢谢支持!';
				break;
			case 4000:
				$msg='用户未登陆！';
				break;
			case 4001:
				$msg='手机号码不正确！';
				break;
			case 4002:
				$msg='绑定手机后才能使用免费电话！';
				break;
			case 4003:
				$msg='您的商讯达人已过有效期，在5天内邀请3人，即可继续使用！';
				break;
			case 4004:
				$msg='该号码不在您的好友群内，只能使用充值时长！';
				break;
			default:
				$msg='请求回呼失败';
				break;
		}
		
		return $msg;
	}


}