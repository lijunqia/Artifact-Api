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
class TRole extends ActiveRecord
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_created, role_updated', 'numerical', 'integerOnly'=>true),
			array('role_name', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('role_id, role_name, role_created, role_updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_id' => 'Role',
			'role_name' => 'Role Name',
			'role_created' => 'Role Created',
			'role_updated' => 'Role Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('role_name',$this->role_name,true);
		$criteria->compare('role_created',$this->role_created);
		$criteria->compare('role_updated',$this->role_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}