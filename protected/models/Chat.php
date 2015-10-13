<?php

/**
 * This is the model class for table "chats".
 *
 * The followings are the available columns in table 'chats':
 * @property string $chat_id
 * @property integer $user_id
 * @property integer $chat_user_id
 * @property string $chat_text
 * @property integer $chat_created
 * @property integer $chat_updated
 */
class Chat extends TChat
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attr()
	{
		$attr = $this->attributes;
		$attr['user'] = User::model()->a($attr['user_id'])->user_name;//发送用户
		$attr['to_user'] = User::model()->a($attr['chat_user_id'])->user_name;//接收用户
		$attr['chat_created'] = date('Y-m-d H:i:s',$attr['chat_created']);
		$attr['chat_updated'] = date('Y-m-d H:i:s',$attr['chat_updated']);
		return $attr;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->chat_updated = time();
			if($this->isNewRecord)
			{
				$this->chat_created = time();
			}

			return true;
		}
		else
			return false;
	}

}