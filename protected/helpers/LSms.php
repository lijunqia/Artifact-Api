<?php
/**
 * Sms class file.
 *
 * @author Jamez <9623595@qq.com>
 * @link http://www.365.vc
 * @copyright Copyright &copy; 2011-2011 jamez
 * @license http://www.365.vc/api/license
 */

/**
 * 短信接口
 *
 * @author Jamez <9623595@qq.com>
 * @version $Id: Sms.php 2011-11-19 $
 * @package components
 * @since 1.0
 * @return 接口返回：<SendState><FailPhone/><State>1</State><Id>803741</Id></SendState>
 * @link http://sms.gknet.com.cn:8180/httphelp.htm
 属性 		类型 		返回值 		说明 						备注
FailPhone 	string 		失败号码 		返回发送失败的号码 				多个失败号码之间以半角分号“;"分隔
Id 			int 		批号 		返回服务器保存发送短信的批号ID 	
State 		int 	 	1 			发送短信成功 	
						-1 			发送失败 	
						-5 			发送短信内容为空 	
						-6 			短信内容过长					短信内容不能超过3条短信的长度
						-7 			发送号码为空 	
						-8 			余额不足 	
						-9 			接收数据失败 	
						-10 		发送失败 						号码错误
						-100 		客户端获取状态失败(系统预留) 	
						其他值 		参考UserLogin()返回值说明 

返回值 	说明 	备注
大于0 	帐户信息正确 	调用接口成功，返回帐户ID值
空值 	调用接口失败 	
0 	帐户处于禁止使用状态 	
-1 	调用接口失败 	
-2 	帐户信息错误 	调用的参数有为空值
-3 	用户或密码错误 	机构代码、用户名或密码错误
-4 	不是普通帐户 	该帐户不能使接口模式调用(如：代理帐户或集团帐户等)
注：只有普通用户才能使用接口调用
-30 	非绑定IP 	访问IP非法
 */
class LSms
{
	/**
	 * 工厂模式
	 * @return model
	 */
	public static function model()
	{
		return new self;
	}
	
	/**
	 * 单发/群发短信
	 * @param array $params 手机号码，多号码使用,分隔
	 * 				- mobile 手机号码，多号码使用,分隔,必填
	 * 				- message 短信内容,必填
	 * 				- SmsAccountID 短信账号,默认1
	 * 				- SmsID 短信模板
	 * 				- SmsClassID 短信分类
	 * 				- MemberID 发送会员
	 * 				- WingID 广告翼族会员
	 * @return boolean
	 */
	public function send($params)
	{
		if(!isset($params['mobile']) || empty($params['mobile']) || empty($params['keyword']))
			return false;
		$params['SmsAccountID']  = isset($params['SmsAccountID'])?intval($params['SmsAccountID']):1;
		$account = SmsAccount::model()->findByPk($params['SmsAccountID']);
		if(!$account || !$account->SmsAccountRequest)return false;
		
		$params['content'] = Sms::content(isset($params['SmsID'])?intval($params['SmsID']):3,$params['keyword']);
		if(!isset($params['content']) || empty($params['content']))
			return false;

		$mobile=$params['mobile'];
		$content=$params['content'];
		$mobiles = array();
		if(strpos($mobile,',')>0 )
		{
			$arr = explode(',', $mobile);
			foreach($arr as $ar)
			{
				if(!LUtil::isMobile($ar))continue;
				$mobiles[] = $ar;
			}
			$mobile = join(';',$mobiles);
		}
		elseif(!LUtil::isMobile($mobile))
			return false;
		$to['Phone'] 		= $mobile;
		$to['Message'] 		= $content;
		$url = $this->buildQuery($account->SmsAccountRequest, $to);
		$ret = LUtil::curl($url);
		$this->log($url,$params,$ret);
		if(strstr($ret,'<State>1</State>'))
			return true;
		else
			return false;
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
		$params['Timestamp'] 	= time();
		return $url . '&' . http_build_query($params, null, '&');
	}
	
	/**
	 * 发送GET/POST
	 * @param string $url 发送地址
	 * @return string the encoded data
	 */
	public function log ($url,$params,$ret)
	{
		$log = new SmsLog();

		$log->SmsID = isset($params['SmsID'])?intval($params['SmsID']):0;
		$log->SmsAccountID = isset($params['SmsAccountID'])?intval($params['SmsAccountID']):0;
		$log->SmsClassID = isset($params['SmsClassID'])?intval($params['SmsClassID']):0;
		$log->MemberID = isset($params['MemberID'])?intval($params['MemberID']):0;
		$log->WingID = isset($params['WingID'])?intval($params['WingID']):0;
		$log->SmsLogContent = $params['content'];
		$log->SmsLogUrl = $url;
		$log->SmsLogResponse = $ret;
		$log->SmsLogMobile = LUtil::substrs($params['mobile'],12,'');
		$log->SmsLogMassMobile = $params['mobile'];
		
		return $log->save();
	}


}