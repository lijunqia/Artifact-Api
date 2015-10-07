<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property string $message_id
 * @property string $user_id
 * @property string $message_text
 * @property integer $message_time
 * @property integer $message_is_exp
 * @property integer $message_created
 * @property integer $message_updated
 */
class Message extends TMessage
{
	public function attr()
	{
		$attr = $this->attributes;
		$attr['message_time'] = date('Y-m-d H:i:s',$attr['message_time']);
		$attr['message_created'] = date('Y-m-d H:i:s',$attr['message_created']);
		$attr['message_updated'] = date('Y-m-d H:i:s',$attr['message_updated']);
		return $attr;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @return TMessage the static model class
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
			$this->message_updated = time();
			if($this->isNewRecord)
			{
				$this->message_created = time();
				if(!$this->message_time)
				$this->message_time = time();
			}

			return true;
		}
		else
			return false;
	}

	protected function  beforeDelete()
	{
		$log = new Log();
		$log->user_id = Yii::app()->user->id;
		$log->log_type_id=4;
		$log->log_text=json_encode($this->attributes);
		$log->save();
		return parent::beforeDelete();
	}
}