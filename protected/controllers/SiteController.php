<?php
/**
 * 默认控制器,不需要登录
 * 
 */
class SiteController extends Controller
{
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
			$this->response($error['code']);
		}
	}

}