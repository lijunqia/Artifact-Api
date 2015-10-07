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
 * @property string $user_remark
 * @property integer $user_created
 * @property integer $user_updated
 */
class TUser extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TUser the static model class
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
			array('role_id, user_parent_id, user_reg_time, user_expire, user_last_time, user_login_num, user_is_delete, user_is_exp, user_created, user_updated', 'numerical', 'integerOnly'=>true),
			array('user_code', 'length', 'max'=>20),
			array('user_password', 'length', 'max'=>40),
			array('user_name, user_reg_ip, user_last_ip', 'length', 'max'=>30),
			array('user_mobile', 'length', 'max'=>11),
			array('user_email', 'length', 'max'=>50),
			array('user_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, role_id, user_parent_id, user_code, user_password, user_name, user_mobile, user_email, user_reg_time, user_reg_ip, user_expire, user_last_time, user_last_ip, user_login_num, user_is_delete, user_is_exp, user_remark, user_created, user_updated', 'safe', 'on'=>'search'),
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
			'role_id' => 'Role',
			'user_parent_id' => 'User Parent',
			'user_code' => 'User Code',
			'user_password' => 'User Password',
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
			'user_remark' => 'User Remark',
			'user_created' => 'User Created',
			'user_updated' => 'User Updated',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('user_parent_id',$this->user_parent_id);
		$criteria->compare('user_code',$this->user_code,true);
		$criteria->compare('user_password',$this->user_password,true);
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
		$criteria->compare('user_remark',$this->user_remark,true);
		$criteria->compare('user_created',$this->user_created);
		$criteria->compare('user_updated',$this->user_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}