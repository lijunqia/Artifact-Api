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
class Notice extends TNotice
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
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->notice_updated = time();
            $this->user_id = Yii::app()->user->id;
            if($this->isNewRecord)
            {
                $this->notice_created = time();
            }

            return true;
        }
        else
            return false;
    }
    public function attr()
    {
        $attr = $this->attributes;
        $attr['user']=User::model()->a($this->user_id)->attr();
        $attr['notice_created'] = date('Y-m-d H:i:s',$attr['notice_created']);
        $attr['notice_updated'] = date('Y-m-d H:i:s',$attr['notice_updated']);
        return $attr;
    }
    protected function  beforeDelete()
    {
        $log = new Log();
        $log->user_id = Yii::app()->user->id;
        $log->log_type_id=5;
        $log->log_text=json_encode($this->attributes);
        $log->save();
        return parent::beforeDelete();
    }
}
