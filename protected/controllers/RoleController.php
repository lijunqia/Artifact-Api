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
	 * ������Ϣ
	 * @param string @text ����
	 * @param int @exp �Ƿ�������Ϣ
	 * @param string @time ����ʱ��
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