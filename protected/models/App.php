<?php

/**
 * This is the model class for table "apps".
 *
 * The followings are the available columns in table 'apps':
 * @property string $app_id
 * @property string $app_name
 * @property string $app_ios_version
 * @property string $app_ios_note
 * @property string $app_ios_url
 * @property string $app_android_version
 * @property string $app_android_note
 * @property string $app_android_url
 * @property integer $app_created
 * @property integer $app_updated
 * @property string $app_creator
 * @property string $app_updator
 */
class App extends TApp
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TApp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attr()
	{
		$attr = $this->attributes;
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
			$this->app_updated = time();
			if($this->isNewRecord)
			{
				$this->app_created = time();
			}
				
			return true;
		}
		else
			return false;
	}

}
