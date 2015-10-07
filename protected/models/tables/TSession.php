<?php

/**
 * This is the model class for table "sessions".
 *
 * The followings are the available columns in table 'sessions':
 * @property string $user_id
 * @property integer $session_expire
 * @property string $session_token
 * @property string $session_ip
 * @property string $session_area
 * @property integer $session_visit_time
 * @property integer $session_last_time
 * @property integer $session_created
 */
class TSession extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
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
			array('session_token', 'length', 'max'=>50),
			array('session_ip', 'length', 'max'=>30),
			array('session_area', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, session_expire, session_token, session_ip, session_area, session_visit_time, session_last_time, session_created', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'session_expire' => 'Session Expire',
			'session_token' => 'Session Token',
			'session_ip' => 'Session Ip',
			'session_area' => 'Session Area',
			'session_visit_time' => 'Session Visit Time',
			'session_last_time' => 'Session Last Time',
			'session_created' => 'Session Created',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('session_expire',$this->session_expire);
		$criteria->compare('session_token',$this->session_token,true);
		$criteria->compare('session_ip',$this->session_ip,true);
		$criteria->compare('session_area',$this->session_area,true);
		$criteria->compare('session_visit_time',$this->session_visit_time);
		$criteria->compare('session_last_time',$this->session_last_time);
		$criteria->compare('session_created',$this->session_created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}