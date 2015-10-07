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
class TChat extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TChat the static model class
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
		return 'chats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, chat_user_id, chat_created, chat_updated', 'numerical', 'integerOnly'=>true),
			array('chat_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('chat_id, user_id, chat_user_id, chat_text, chat_created, chat_updated', 'safe', 'on'=>'search'),
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
			'chat_id' => 'Chat',
			'user_id' => 'User',
			'chat_user_id' => 'Chat User',
			'chat_text' => 'Chat Text',
			'chat_created' => 'Chat Created',
			'chat_updated' => 'Chat Updated',
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

		$criteria->compare('chat_id',$this->chat_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('chat_user_id',$this->chat_user_id);
		$criteria->compare('chat_text',$this->chat_text,true);
		$criteria->compare('chat_created',$this->chat_created);
		$criteria->compare('chat_updated',$this->chat_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}