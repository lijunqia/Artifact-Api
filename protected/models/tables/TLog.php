<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property string $log_id
 * @property string $user_id
 * @property integer $log_type_id
 * @property string $log_text
 * @property integer $log_created
 */
class TLog extends ActiveRecord
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('log_type_id, log_created', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('log_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('log_id, user_id, log_type_id, log_text, log_created', 'safe', 'on'=>'search'),
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
			'log_id' => 'Log',
			'user_id' => 'User',
			'log_type_id' => 'Log Type',
			'log_text' => 'Log Text',
			'log_created' => 'Log Created',
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

		$criteria->compare('log_id',$this->log_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('log_type_id',$this->log_type_id);
		$criteria->compare('log_text',$this->log_text,true);
		$criteria->compare('log_created',$this->log_created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}