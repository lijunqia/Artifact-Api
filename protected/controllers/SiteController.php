<?php
/**
 * 默认控制器,不需要登录
 * 
 */
class SiteController extends Controller
{
	/**
	 * 版本更新
	 */
	public function actionUpdate()
	{
		header('Content-type: application/json');
		$appid = Yii::app()->request->getParam('appid','');
		$data = array();
		if($appid)
		{
			$app = App::model()->findByPk($appid);
			$data = array(
				"appid"=>$app['app_id'],
				"iOS"=>array(
					"version"=>$app['app_ios_version'],
					"note"=>$app['app_ios_note'],
					"url"=>$app['app_ios_url']
				),
				"Android"=>array(
					"version"=>$app['app_android_version'],
					"note"=>$app['app_android_note'],
					"url"=>$app['app_android_url']
				)
			);
		}
		else{
			$data = array(
				"appid"=>"H5B567DCF",
				"iOS"=>array(
					"version"=>"1.0.0",
					"note"=>"",
					"url"=>""
				),
				"Android"=>array(
					"version"=>"1.0.7",
					"note"=>"优化图片上传",
					"url"=>Yii::app()->request->hostInfo . Yii::app()->params->upload."/app.apk"
				)
			);

		}
		echo json_encode($data);
		Yii::app()->end();
	}

	/**
	 * 输入语音文件
	 */
	public function actionVoice()
	{
		$filename = Yii::app()->request->getParam('url','');
		if(!$filename)exit();
		$filename = base64_decode($filename);
		$data = file_get_contents($filename);
		echo base64_encode($data);
	}

	/**
	 * 下载页面
	 */
	public function actionDown()
	{
		$this->render('down');
	}
	/**
	 * 登录接口
	 * @appkey 系统分配应用KEY
	 * @code 登录账号,手机,资源码,必填
	 * @pwd 登录密码,必填
	 * @longitude 经度
	 * @latitude 纬度
	 */
	public function actionLogin()
	{
		$params = array(
			'code' => Yii::app()->request->getParam('code',''),
			'pwd' => Yii::app()->request->getParam('pwd',''),
			'longitude' => Yii::app()->request->getParam('longitude',''),
			'latitude' => Yii::app()->request->getParam('latitude',''),
			'uuid' => Yii::app()->request->getParam('uuid',''),
		);
		if(empty($params['code']) || empty($params['pwd']))
			$this->response(1006);

		$ret = User::model()->login($params['code'],$params['pwd']);
		if($ret === true)
		{
			$data = Yii::app()->user->getState('user')->attr();
			$data['token']=Yii::app()->user->getState('session')->session_token;
			unset($data['user_password']);
			$this->response(0,$data);
		}
		elseif(is_numeric($ret))
			$this->response($ret);
		else
			$this->response(1001);

	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        if(Yii::app()->request->getParam('t') != '1')Yii::app()->end();

		$session = Session::model()->find('user_id=1');
		$this->render('index', array('appkey'=>'','session'=>$session,'token'=>$session->session_token));
	}

	/**
	 * 错误信息
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			$this->response($error);
		}
	}

}