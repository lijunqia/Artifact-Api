<?php

/**
 * This is the model class for table "chats".
 *
 * The followings are the available columns in table 'chats':
 * @property string $chat_id
 * @property integer $user_id
 * @property integer $chat_user_id
 * @property string $chat_text
 * @property string $chat_media
 * @property string $chat_media_type
 * @property integer $chat_is_read
 * @property integer $chat_created
 * @property integer $chat_updated
 */
class TChat extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
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
			array('user_id, chat_user_id, chat_is_read, chat_created, chat_updated', 'numerical', 'integerOnly'=>true),
			array('chat_media', 'length', 'max'=>100),
			array('chat_media_type', 'length', 'max'=>10),
			array('chat_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('chat_id, user_id, chat_user_id, chat_text, chat_media, chat_media_type, chat_is_read, chat_created, chat_updated', 'safe', 'on'=>'search'),
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
	/*
		return array(
			'chat_id' => 'Chat',
			'user_id' => 'User',
			'chat_user_id' => 'Chat User',
			'chat_text' => 'Chat Text',
			'chat_media' => 'Chat Media',
			'chat_media_type' => 'Chat Media Type',
			'chat_is_read' => 'Chat Is Read',
			'chat_created' => 'Chat Created',
			'chat_updated' => 'Chat Updated',
		);
	*/
		$source = get_class($this);
		return array(
			'chat_id' => Yii::t($source,'chat_id'),
			'user_id' => Yii::t($source,'user_id'),
			'chat_user_id' => Yii::t($source,'chat_user_id'),
			'chat_text' => Yii::t($source,'chat_text'),
			'chat_media' => Yii::t($source,'chat_media'),
			'chat_media_type' => Yii::t($source,'chat_media_type'),
			'chat_is_read' => Yii::t($source,'chat_is_read'),
			'chat_created' => Yii::t($source,'chat_created'),
			'chat_updated' => Yii::t($source,'chat_updated'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('chat_id',$this->chat_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('chat_user_id',$this->chat_user_id);
		$criteria->compare('chat_text',$this->chat_text,true);
		$criteria->compare('chat_media',$this->chat_media,true);
		$criteria->compare('chat_media_type',$this->chat_media_type,true);
		$criteria->compare('chat_is_read',$this->chat_is_read);
		$criteria->compare('chat_created',$this->chat_created);
		$criteria->compare('chat_updated',$this->chat_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
			}
				
			return true;
		}
		else
			return false;
	}

}
