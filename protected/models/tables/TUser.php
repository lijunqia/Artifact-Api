<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $user_id
 * @property integer $role_id
 * @property integer $user_parent_id
 * @property string $user_code
 * @property string $user_password
 * @property string $user_avatar
 * @property string $user_name
 * @property string $user_mobile
 * @property string $user_email
 * @property integer $user_reg_time
 * @property string $user_reg_ip
 * @property integer $user_expire
 * @property integer $user_last_time
 * @property string $user_last_ip
 * @property integer $user_login_num
 * @property integer $user_is_delete
 * @property integer $user_is_exp
 * @property integer $user_is_service
 * @property string $user_remark
 * @property integer $user_created
 * @property integer $user_updated
 */
class TUser extends ActiveRecord
{
	/**
	* Returns the static model of the specified AR class.
	* Please note that you should have this exact method in all your CActiveRecord descendants!
	* @param string $className active record class name.
	* @return TUser the static model class
	*/
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels()
	{
/*
return array(
	'user_id' => 'User',
	'role_id' => 'Role',
	'user_parent_id' => 'User Parent',
	'user_code' => 'User Code',
	'user_password' => 'User Password',
	'user_avatar' => 'User Avatar',
	'user_name' => 'User Name',
	'user_mobile' => 'User Mobile',
	'user_email' => 'User Email',
	'user_reg_time' => 'User Reg Time',
	'user_reg_ip' => 'User Reg Ip',
	'user_expire' => 'User Expire',
	'user_last_time' => 'User Last Time',
	'user_last_ip' => 'User Last Ip',
	'user_login_num' => 'User Login Num',
	'user_is_delete' => 'User Is Delete',
	'user_is_exp' => 'User Is Exp',
	'user_is_service' => 'User Is Service',
	'user_remark' => 'User Remark',
	'user_created' => 'User Created',
	'user_updated' => 'User Updated',
);
*/
		$source = get_class($this);
		return array(
			'user_id' => Yii::t($source,'user_id'),
			'role_id' => Yii::t($source,'role_id'),
			'user_parent_id' => Yii::t($source,'user_parent_id'),
			'user_code' => Yii::t($source,'user_code'),
			'user_password' => Yii::t($source,'user_password'),
			'user_avatar' => Yii::t($source,'user_avatar'),
			'user_name' => Yii::t($source,'user_name'),
			'user_mobile' => Yii::t($source,'user_mobile'),
			'user_email' => Yii::t($source,'user_email'),
			'user_reg_time' => Yii::t($source,'user_reg_time'),
			'user_reg_ip' => Yii::t($source,'user_reg_ip'),
			'user_expire' => Yii::t($source,'user_expire'),
			'user_last_time' => Yii::t($source,'user_last_time'),
			'user_last_ip' => Yii::t($source,'user_last_ip'),
			'user_login_num' => Yii::t($source,'user_login_num'),
			'user_is_delete' => Yii::t($source,'user_is_delete'),
			'user_is_exp' => Yii::t($source,'user_is_exp'),
			'user_is_service' => Yii::t($source,'user_is_service'),
			'user_remark' => Yii::t($source,'user_remark'),
			'user_created' => Yii::t($source,'user_created'),
			'user_updated' => Yii::t($source,'user_updated'),
			);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, user_parent_id, user_reg_time, user_expire, user_last_time, user_login_num, user_is_delete, user_is_exp, user_is_service, user_created, user_updated', 'numerical', 'integerOnly'=>true),
			array('user_code', 'length', 'max'=>20),
			array('user_password', 'length', 'max'=>40),
			array('user_avatar', 'length', 'max'=>100),
			array('user_name, user_reg_ip, user_last_ip', 'length', 'max'=>30),
			array('user_mobile', 'length', 'max'=>11),
			array('user_email', 'length', 'max'=>50),
			array('user_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, role_id, user_parent_id, user_code, user_password, user_avatar, user_name, user_mobile, user_email, user_reg_time, user_reg_ip, user_expire, user_last_time, user_last_ip, user_login_num, user_is_delete, user_is_exp, user_is_service, user_remark, user_created, user_updated', 'safe', 'on'=>'search'),
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
	public function search($params = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('user_parent_id',$this->user_parent_id);
		$criteria->compare('user_code',$this->user_code,true);
		$criteria->compare('user_password',$this->user_password,true);
		$criteria->compare('user_avatar',$this->user_avatar,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_mobile',$this->user_mobile,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_reg_time',$this->user_reg_time);
		$criteria->compare('user_reg_ip',$this->user_reg_ip,true);
		$criteria->compare('user_expire',$this->user_expire);
		$criteria->compare('user_last_time',$this->user_last_time);
		$criteria->compare('user_last_ip',$this->user_last_ip,true);
		$criteria->compare('user_login_num',$this->user_login_num);
		$criteria->compare('user_is_delete',$this->user_is_delete);
		$criteria->compare('user_is_exp',$this->user_is_exp);
		$criteria->compare('user_is_service',$this->user_is_service);
		$criteria->compare('user_remark',$this->user_remark,true);
		$criteria->compare('user_created',$this->user_created);
		$criteria->compare('user_updated',$this->user_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>isset($params['size'])?intval($params['size']):10, //代表每页显示30条信息
			),
			'sort'=>array(
				'defaultOrder'=>isset($params['order'])?$params['order']:$this->getTableSchema()->primaryKey.' DESC',
			),
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
				$this->user_reg_ip = Yii::app()->request->getUserHostAddress();
				$this->user_last_ip = Yii::app()->request->getUserHostAddress();
			}

			return true;
		}
		else
			return false;
	}

}
