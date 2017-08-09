<?php

/**
 * This is the model class for table "status".
 *
 * The followings are the available columns in table 'status':
 * @property string $status_id
 * @property string $status_code
 * @property string $status_name
 * @property integer $status_created
 */
class Status extends TStatus
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 根据状态码返回状态说明
	 * @return string
	 */
	public static function item($code)
	{
		$model = self::model()->find(array(
			'condition'=>'status_code=:code',
			'params'=>array(':code'=>$code),
		));

		if($model)
			return $model->status_name === null?'':$model->status_name;
		else
			return '';
	}

}