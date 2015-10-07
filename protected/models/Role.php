<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property string $role_id
 * @property string $role_name
 * @property integer $role_created
 * @property integer $role_updated
 */
class Role extends TRole
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}