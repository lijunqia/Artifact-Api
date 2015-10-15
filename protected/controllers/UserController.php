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
			'>'=>array('user_expire'=>time()),
			'user_is_service' => 1,
			'other' => array(
				'order' => Yii::app()->request->getParam('order','user_id'),
			),
		);

		$this->response(0,User::model()->services($params));
	}

	/**
	 * ע��ӿ�
	 * @appkey ϵͳ����Ӧ��KEY
	 * @pid ������ID
	 * @pcode �������˻����ֻ�
	 * @code �˺�,��Ϊ��
	 * @pwd ����,����
	 * @name ����,��Ϊ��
	 * @mobie �ֻ�,����
	 * @email ����,��Ϊ��
	 * @province ʡ
	 * @city ��
	 * @area ��
	 * @key ��֤��֤��ɹ��󷵻صĲ����ٻش���������
	 */
	public function actionUpdate()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		$params = array(
			'id' => intval(Yii::app()->request->getParam('id',0)),
			'service' => intval(Yii::app()->request->getParam('service',0)),
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
		$model->user_is_service = intval($params['service']);
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
	 * ע��ӿ�
	 * @appkey ϵͳ����Ӧ��KEY
	 * @pid ������ID
	 * @pcode �������˻����ֻ�
	 * @code �˺�,��Ϊ��
	 * @pwd ����,����
	 * @name ����,��Ϊ��
	 * @mobie �ֻ�,����
	 * @email ����,��Ϊ��
	 * @province ʡ
	 * @city ��
	 * @area ��
	 * @key ��֤��֤��ɹ��󷵻صĲ����ٻش���������
	 */
	public function actionCreate()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			$this->response(1000);
		$params = array(
			'pcode' => Yii::app()->request->getParam('pcode',''),
			'service' => intval(Yii::app()->request->getParam('service',0)),
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
	 * ������Ϣ
	 * @param string @text ����
	 * @param int @exp �Ƿ�������Ϣ
	 * @param string @time ����ʱ��
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
	 * �޸�����ӿ�
	 * @param string $appkey ϵͳ����Ӧ��KEY
	 * @param string $token �û���¼��ϵͳ�����token
	 * @param string $old ԭ����
	 * @param string $pwd ������
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