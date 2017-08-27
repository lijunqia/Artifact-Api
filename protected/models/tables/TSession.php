<?php

/**
 * This is the model class for table "sessions".
 *
 * The followings are the available columns in table 'sessions':
 * @property string $session_id
 * @property string $user_id
 * @property string $session_client
 * @property integer $session_expire
 * @property string $session_token
 * @property string $session_ip
 * @property string $session_area
 * @property string $session_uuid
 * @property integer $session_visit_time
 * @property integer $session_last_time
 * @property integer $session_created
 */
class TSession extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TSession the static model class
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
		return 'sessions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_expire, session_visit_time, session_last_time, session_created', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('session_client', 'length', 'max'=>10),
			array('session_token, session_uuid', 'length', 'max'=>50),
			array('session_ip', 'length', 'max'=>30),
			array('session_area', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_id, user_id, session_client, session_expire, session_token, session_ip, session_area, session_uuid, session_visit_time, session_last_time, session_created', 'safe', 'on'=>'search'),
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
			'session_id' => 'Session',
			'user_id' => 'User',
			'session_client' => 'Session Client',
			'session_expire' => 'Session Expire',
			'session_token' => 'Session Token',
			'session_ip' => 'Session Ip',
			'session_area' => 'Session Area',
			'session_uuid' => 'Session Uuid',
			'session_visit_time' => 'Session Visit Time',
			'session_last_time' => 'Session Last Time',
			'session_created' => 'Session Created',
		);
	*/
		$source = get_class($this);
		return array(
			'session_id' => Yii::t($source,'session_id'),
			'user_id' => Yii::t($source,'user_id'),
			'session_client' => Yii::t($source,'session_client'),
			'session_expire' => Yii::t($source,'session_expire'),
			'session_token' => Yii::t($source,'session_token'),
			'session_ip' => Yii::t($source,'session_ip'),
			'session_area' => Yii::t($source,'session_area'),
			'session_uuid' => Yii::t($source,'session_uuid'),
			'session_visit_time' => Yii::t($source,'session_visit_time'),
			'session_last_time' => Yii::t($source,'session_last_time'),
			'session_created' => Yii::t($source,'session_created'),
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

		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('session_client',$this->session_client,true);
		$criteria->compare('session_expire',$this->session_expire);
		$criteria->compare('session_token',$this->session_token,true);
		$criteria->compare('session_ip',$this->session_ip,true);
		$criteria->compare('session_area',$this->session_area,true);
		$criteria->compare('session_uuid',$this->session_uuid,true);
		$criteria->compare('session_visit_time',$this->session_visit_time);
		$criteria->compare('session_last_time',$this->session_last_time);
		$criteria->compare('session_created',$this->session_created);

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
