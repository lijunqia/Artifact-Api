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
	/**
	 * Returns the items for the specified type.
	 * @param string item type (e.g. 'PostStatus').
	 * @return array item names indexed by item code. The items are order by their position values.
	 * An empty array is returned if the item type does not exist.
	 */
	public static function items()
	{
		if(!isset(self::$_items[self::model()->tableName()]))
			self::loadItems();
		return self::$_items[self::model()->tableName()];
	}

	/**
	 * Returns the item name for the specified type and code.
	 * @param string the item type (e.g. 'PostStatus').
	 * @param integer the item code (corresponding to the 'code' column value)
	 * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
	 */
	public static function item($id)
	{
		if(!isset(self::$_items[self::model()->tableName()]))
			self::loadItems();
		return isset(self::$_items[self::model()->tableName()][$id]) ? self::$_items[self::model()->tableName()][$id] : false;
	}

	/**
	 * Loads the lookup items for the specified type from the database.
	 * @param string the item type
	 */
	private static function loadItems()
	{
		self::$_items[self::model()->tableName()]=array();
		$models=self::model()->findAll();
		foreach($models as $model)
			self::$_items[self::model()->tableName()][$model->primaryKey]=$model->role_name;
	}

}