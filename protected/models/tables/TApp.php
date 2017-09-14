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
class TApp extends ActiveRecord
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

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_id', 'required'),
			array('app_created, app_updated', 'numerical', 'integerOnly'=>true),
			array('app_id', 'length', 'max'=>9),
			array('app_name, app_ios_note, app_ios_url, app_android_note, app_android_url', 'length', 'max'=>255),
			array('app_ios_version, app_android_version', 'length', 'max'=>10),
			array('app_creator, app_updator', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('app_id, app_name, app_ios_version, app_ios_note, app_ios_url, app_android_version, app_android_note, app_android_url, app_created, app_updated, app_creator, app_updator', 'safe', 'on'=>'search'),
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
			'app_id' => 'App',
			'app_name' => 'App Name',
			'app_ios_version' => 'App Ios Version',
			'app_ios_note' => 'App Ios Note',
			'app_ios_url' => 'App Ios Url',
			'app_android_version' => 'App Android Version',
			'app_android_note' => 'App Android Note',
			'app_android_url' => 'App Android Url',
			'app_created' => 'App Created',
			'app_updated' => 'App Updated',
			'app_creator' => 'App Creator',
			'app_updator' => 'App Updator',
		);
	*/
		$source = get_class($this);
		return array(
			'app_id' => Yii::t($source,'app_id'),
			'app_name' => Yii::t($source,'app_name'),
			'app_ios_version' => Yii::t($source,'app_ios_version'),
			'app_ios_note' => Yii::t($source,'app_ios_note'),
			'app_ios_url' => Yii::t($source,'app_ios_url'),
			'app_android_version' => Yii::t($source,'app_android_version'),
			'app_android_note' => Yii::t($source,'app_android_note'),
			'app_android_url' => Yii::t($source,'app_android_url'),
			'app_created' => Yii::t($source,'app_created'),
			'app_updated' => Yii::t($source,'app_updated'),
			'app_creator' => Yii::t($source,'app_creator'),
			'app_updator' => Yii::t($source,'app_updator'),
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

		$criteria->compare('app_id',$this->app_id,true);
		$criteria->compare('app_name',$this->app_name,true);
		$criteria->compare('app_ios_version',$this->app_ios_version,true);
		$criteria->compare('app_ios_note',$this->app_ios_note,true);
		$criteria->compare('app_ios_url',$this->app_ios_url,true);
		$criteria->compare('app_android_version',$this->app_android_version,true);
		$criteria->compare('app_android_note',$this->app_android_note,true);
		$criteria->compare('app_android_url',$this->app_android_url,true);
		$criteria->compare('app_created',$this->app_created);
		$criteria->compare('app_updated',$this->app_updated);
		$criteria->compare('app_creator',$this->app_creator,true);
		$criteria->compare('app_updator',$this->app_updator,true);

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
