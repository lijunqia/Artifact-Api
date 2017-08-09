<?php

/**
 * This is the model class for table "notices".
 *
 * The followings are the available columns in table 'notices':
 * @property string $notice_id
 * @property integer $user_id
 * @property string $notice_body
 * @property integer $notice_created
 * @property integer $notice_updated
 */
class TNotice extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TNotice the static model class
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
		return 'notices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, notice_created, notice_updated', 'numerical', 'integerOnly'=>true),
			array('notice_body', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notice_id, user_id, notice_body, notice_created, notice_updated', 'safe', 'on'=>'search'),
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
			'notice_id' => 'Notice',
			'user_id' => 'User',
			'notice_body' => 'Notice Body',
			'notice_created' => 'Notice Created',
			'notice_updated' => 'Notice Updated',
		);
	*/
		$source = get_class($this);
		return array(
			'notice_id' => Yii::t($source,'notice_id'),
			'user_id' => Yii::t($source,'user_id'),
			'notice_body' => Yii::t($source,'notice_body'),
			'notice_created' => Yii::t($source,'notice_created'),
			'notice_updated' => Yii::t($source,'notice_updated'),
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

		$criteria->compare('notice_id',$this->notice_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('notice_body',$this->notice_body,true);
		$criteria->compare('notice_created',$this->notice_created);
		$criteria->compare('notice_updated',$this->notice_updated);

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
