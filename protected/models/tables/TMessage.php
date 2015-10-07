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
class TMessage extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TMessage the static model class
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
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_time, message_is_exp, message_created, message_updated', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('message_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('message_id, user_id, message_text, message_time, message_is_exp, message_created, message_updated', 'safe', 'on'=>'search'),
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
			'message_id' => 'Message',
			'user_id' => 'User',
			'message_text' => 'Message Text',
			'message_time' => 'Message Time',
			'message_is_exp' => 'Message Is Exp',
			'message_created' => 'Message Created',
			'message_updated' => 'Message Updated',
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

		$criteria->compare('message_id',$this->message_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('message_text',$this->message_text,true);
		$criteria->compare('message_time',$this->message_time);
		$criteria->compare('message_is_exp',$this->message_is_exp);
		$criteria->compare('message_created',$this->message_created);
		$criteria->compare('message_updated',$this->message_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}