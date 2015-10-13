<?php

class UserController extends Controller
{

	public function actionIndex()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		$minid = intval(Yii::app()->request->getParam('min',0));
		$exp = intval(Yii::app()->request->getParam('exp',-1));
		$is_service = intval(Yii::app()->request->getParam('service',-1));
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',10)),
				'order' => Yii::app()->request->getParam('order','user_id'),
			),
			'>'=>array('user_id'=> $minid),
			'like' => array(
				'user_code'=>Yii::app()->request->getParam('q',''),
				'user_name'=>Yii::app()->request->getParam('q',''),
				'user_mobile'=>Yii::app()->request->getParam('q',''),
				'user_remark'=>Yii::app()->request->getParam('q','')
			),
		);
		if($exp!=-1)
			$params['user_is_exp'] = array($exp);
		if($is_service!=-1)
			$params['user_is_service'] = array($is_service);


		$this->response(0,User::model()->lists($params));
	}

	public function actionService()
	{
		$params = array(
			'user_is_service' => 1,
			'other' => array(
				'order' => Yii::app()->request->getParam('order','user_id'),
			),
		);

		$this->response(0,User::model()->services($params));
	}

	/**
	 * 注册接口
	 * @appkey 系统分配应用KEY
	 * @pid 邀请人ID
	 * @pcode 邀请人账户或手机
	 * @code 账号,可为空
	 * @pwd 密码,必填
	 * @name 姓名,可为空
	 * @mobie 手机,必填
	 * @email 邮箱,可为空
	 * @province 省
	 * @city 市
	 * @area 区
	 * @key 验证验证码成功后返回的参数再回传到服务器
	 */
	public function actionUpdate()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		$params = array(
			'id' => intval(Yii::app()->request->getParam('id',0)),
			'pcode' => Yii::app()->request->getParam('pcode',''),
			'code' => Yii::app()->request->getParam('code',''),
			'name' => Yii::app()->request->getParam('name',''),
			'pwd' => Yii::app()->request->getParam('pwd',''),
			'mobile' => Yii::app()->request->getParam('mobile',''),
			'email' => Yii::app()->request->getParam('email',''),
			'remark' => Yii::app()->request->getParam('remark',''),
			'role' => Yii::app()->request->getParam('role',2),
			'expire' => Yii::app()->request->getParam('expire',date('Y-m-d H:i:s')),
		);

		if(empty($params['id']) || empty($params['code']))
			$this->response(1006);

		$model = User::model()->findByPk($params['id']);

		if(!$model)
		{
			$this->response(1007);
		}
		$model->user_code = $params['code'];
		$model->user_name = $params['name'];
		$model->user_password = $params['pwd'];
		$model->role_id = intval($params['role']);
		$model->user_mobile = $params['mobile'];
		$model->user_email = $params['email'];
		$model->user_remark = $params['remark'];
		$model->user_expire = strtotime($params['expire']);
		if($model->save())
		{
			$log = new Log();
			$log->user_id = Yii::app()->user->id;
			$log->log_type_id=1;
			$log->log_text=json_encode($model->attributes);
			$log->save();
			$this->response(0,$model->attr());
		}
		else
			$this->response(1001);
	}

	/**
	 * 注册接口
	 * @appkey 系统分配应用KEY
	 * @pid 邀请人ID
	 * @pcode 邀请人账户或手机
	 * @code 账号,可为空
	 * @pwd 密码,必填
	 * @name 姓名,可为空
	 * @mobie 手机,必填
	 * @email 邮箱,可为空
	 * @province 省
	 * @city 市
	 * @area 区
	 * @key 验证验证码成功后返回的参数再回传到服务器
	 */
	public function actionCreate()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		$params = array(
			'pcode' => Yii::app()->request->getParam('pcode',''),
			'code' => Yii::app()->request->getParam('code',''),
			'name' => Yii::app()->request->getParam('name',''),
			'pwd' => Yii::app()->request->getParam('pwd',''),
			'mobile' => Yii::app()->request->getParam('mobile',''),
			'email' => Yii::app()->request->getParam('email',''),
			'remark' => Yii::app()->request->getParam('remark',''),
			'role' => Yii::app()->request->getParam('role',2),
			'expire' => Yii::app()->request->getParam('expire',date('Y-m-d H:i:s')),
		);

		if(empty($params['code']))
			$this->response(1006);

		$model = User::model()->regist($params);
		if(is_object($model))
		{
			$this->response(0,$model->attr());
		}
		if(is_int($model))
			$this->response($model);
		else
			$this->response(1001);
	}

	/**
	 * 发布信息
	 * @param string @text 内容
	 * @param int @exp 是否体验信息
	 * @param string @time 发布时间
	 *
	 * @return mixed json
	 */
	public function actionDelete()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		if(User::model()->deleteByPk(intval(Yii::app()->request->getParam('id',0))))
		{
			$this->response(0);
		}
		else
			$this->response(1001);
	}

	/**
	 * 修改密码接口
	 * @param string $appkey 系统分配应用KEY
	 * @param string $token 用户登录后系统分配的token
	 * @param string $old 原密码
	 * @param string $pwd 新密码
	 */
	public function actionReset()
	{
		$params = array(
			'old' => Yii::app()->request->getParam('old',''),
			'pwd' => Yii::app()->request->getParam('pwd',''),
		);
		if(!$params['old'] || !$params['pwd'])
			$this->response(1006);

		$model = User::model()->findByPk(Yii::app()->user->id);
		if(!$model)
			$this->response(1007);

		if(!$model->validatePassword($params['old']))
			$this->response(1008);

		if($model->resetPassword($params['pwd']))
			$this->response(0);
		else
			$this->response(1001);
	}


}