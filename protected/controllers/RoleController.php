<?php

class RoleController extends Controller
{

	public function actionIndex()
	{
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',10)),
				'order' => Yii::app()->request->getParam('order','role_id'),
			),
			'like' => array('role_name'=>Yii::app()->request->getParam('q','')),
		);


		$this->response(0, Role::model()->all($params));
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
		$params = array(
			'exp' => intval(Yii::app()->request->getParam('exp',0)),
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