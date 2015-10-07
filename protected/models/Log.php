<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property string $log_id
 * @property integer $log_type_id
 * @property string $log_text
 * @property integer $log_created
 */
class Log extends TLog
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TLog the static model class
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
			if($this->isNewRecord)
			{
				$this->log_created = time();
			}

			return true;
		}
		else
			return false;
	}

}