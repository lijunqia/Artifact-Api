<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{	
	/** 
    * User's attributes 
    * @var int 
    */
    private $_id;
    private $_name;
	const ERROR_EXPIRE_INVALID=3;//¹ıÆÚ
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{		
		if(!isset($this->username))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(!isset($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$user = User::model()->find("user_code='".CHtml::encode($this->username)."'");


			if(!$user)
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			elseif($user->user_expire<time())
			{
				$this->errorCode=self::ERROR_EXPIRE_INVALID;
			}
			else
			{ 
				if (!$user->user_is_delete && $user->validatePassword($this->password))
				{
					$user->user_last_time = time();
					$user->user_last_ip = Yii::app()->request->getUserHostAddress();
					$user->user_login_num += 1;

					$user->save();
           			$this->setUser($user);
				}
				else
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			unset($user);
		}

        return !$this->errorCode; 
	}
	
	public function getId()
	{
		return $this->_id;
	}

    public function getName()
    {
        return $this->_name;
    }
    public function setUser($user)
    {
        $this->_id = $user->user_id;
        $this->_name = $user->user_name;
        $this->errorCode=self::ERROR_NONE;
        $this->setState('user',$user);
    }
}