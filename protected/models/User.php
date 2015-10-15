<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $user_id
 * @property string $user_code
 * @property string $user_password
 * @property string $user_name
 * @property string $user_mobile
 * @property string $user_email
 * @property integer $user_reg_time
 * @property string $user_reg_ip
 * @property integer $user_expire
 * @property integer $user_last_time
 * @property string $user_last_ip
 * @property integer $user_login_num
 * @property integer $user_is_delete
 * @property integer $user_is_exp
 * @property integer $user_is_service
 * @property integer $user_created
 * @property integer $user_updated
 */
class User extends TUser
{
	public function regist($params)
	{
		if($this->exists("user_code='".$params['code']."'"))
			return 1002;

		$model = new self;

		$model->user_code = $params['code'];
		$model->user_is_service = intval($params['service']);
		$model->user_password = $this->hashPassword($params['pwd']);
		$model->user_email = $params['email'];
		$model->user_name = $params['name'];
		$model->user_expire = strtotime($params['expire']);
		$model->user_remark = $params['remark'];
		$model->role_id = intval($params['role']);
		if($model->role_id==5)
			$model->user_is_exp = 1;
		if($model->save())
			return $model;


		return 1003;


	}
	public function login($code,$pwd)
	{
		$identity=new UserIdentity($code,$pwd);
		$identity->authenticate();

		switch($identity->errorCode)
		{
			case UserIdentity::ERROR_NONE:
				Yii::app()->user->login($identity,0);
				return Session::model()->token();
				break;
			case UserIdentity::ERROR_EXPIRE_INVALID:
				return 1005;
				break;
			case UserIdentity::ERROR_USERNAME_INVALID:
				return 1007;
				break;
			case UserIdentity::ERROR_PASSWORD_INVALID:
				return 1009;
				break;
			default:
				break;
		}

		return false;
	}
	/**
	 * 验证密码
	 * @return boolean
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password)===$this->user_password;
	}

	/**
	 * 重设密码
	 * @return boolean
	 */
	public function resetPassword($password)
	{
		$this->user_password = $this->hashPassword($password);
		$log = new Log();
		$log->user_id = Yii::app()->user->id;
		$log->log_type_id=2;
		$log->log_text=json_encode($this->attributes);
		$log->save();
		return $this->save();
	}

	/**
	 * 加密密码
	 * @return string
	 */
	public function hashPassword($password)
	{
		return $password;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return TUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->user_updated = time();
			if($this->isNewRecord)
			{
				$this->user_created = time();
				$this->user_reg_ip = Yii::app()->request->getUserHostAddress();
				$this->user_reg_time =time();

			}

			return true;
		}
		else
			return false;
	}

	public function attr()
	{
		$attr = $this->attributes;
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,3)))
			unset($attr['user_password']);
		$attr['user_reg_time'] = date('Y-m-d H:i:s',$attr['user_reg_time']);
		$attr['user_updated'] = date('Y-m-d H:i:s',$attr['user_updated']);
		$attr['user_created'] = date('Y-m-d H:i:s',$attr['user_created']);
		$attr['user_expire'] = date('Y-m-d H:i:s',$attr['user_expire']);
		$attr['user_last_time'] = date('Y-m-d H:i:s',$attr['user_last_time']);
		return $attr;
	}

	protected function beforeDelete()
	{
		$log = new Log();
		$log->user_id = Yii::app()->user->id;
		$log->log_type_id=3;
		$log->log_text=json_encode($this->attributes);
		$log->save();
		return parent::beforeDelete();
	}

	public function services($params)
	{
		$models = User::model()->all($params);
		$data=array();
		foreach($models['data'] as $model)
		{
			$data[]=array(
				'user_id' => $model['user_id'],
				'user_name' => $model['user_name'],
			);
		}
		$models['data'] = $data;
		return $models;
	}

}