<?php

/**
 * This is the model class for table "sessions".
 *
 * The followings are the available columns in table 'sessions':
 * @property string $user_id
 * @property integer $session_expire
 * @property string $session_token
 * @property string $session_ip
 * @property string $session_area
 * @property integer $session_visit_time
 * @property integer $session_last_time
 * @property integer $session_created
 */
class Session extends TSession
{
	public function attr()
	{
		$attr = $this->attributes;
        $attr['user']=User::model()->a($this->user_id)->attr();
		$attr['session_visit_time'] = date('Y-m-d H:i:s',$attr['session_visit_time']);
		$attr['session_created'] = date('Y-m-d H:i:s',$attr['session_created']);
		$attr['session_last_time'] = date('Y-m-d H:i:s',$attr['session_last_time']);
		return $attr;
	}
	public function verify($token)
	{
		$model = self::model()->find("session_token ='$token' and session_expire>UNIX_TIMESTAMP()");
		if(!$model)return false;

		$user = User::model()->findByPk($model->user_id);
		if(!$user)return false;
		Yii::app()->user->setState('user',$user);
		Yii::app()->user->setState('session',$model);
		Yii::app()->user->id = $user->user_id;
		Yii::app()->user->name = $user->user_code;

		return true;
	}
	public function token()
	{
		$client = Yii::app()->request->getParam('client','');
		$model = self::model()->findByPk(Yii::app()->user->id);
		if(!$model)$model=new self;
		$model->session_client = $client;
		$model->session_expire= Yii::app()->user->getState('user')->user_expire;
		$model->session_last_time = $model->session_visit_time;
		$model->session_token = session_id();
		$model->user_id = Yii::app()->user->id;
		$model->session_ip=Yii::app()->request->getUserHostAddress();

		$ip = new LIpLocation();
		$ip->getIpLocation($model->session_ip);
		$model->session_area = $ip->country.$ip->area;

		if(!$model->save())
			return false;

		Yii::app()->user->setState('session',$model);

		return true;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return TSession the static model class
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
			$this->session_visit_time= time();
			if($this->isNewRecord)
			{
				$this->session_created = time();
			}

			return true;
		}
		else
			return false;
	}

}