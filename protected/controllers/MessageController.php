<?php

class MessageController extends Controller
{
	public function actionIndex()
	{
		$minid = intval(Yii::app()->request->getParam('min',0));
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',10)),
				'order' => Yii::app()->request->getParam('order','message_id'),
			),
			'>'=>array('message_id'=> $minid,'message_created'=>time()-604800),
			'like' => array('message_text'=>Yii::app()->request->getParam('q','')),
		);
		switch(Yii::app()->user->getState('user')->role_id)
		{
			case 1://����Ա
			case 2://��Ϣ����
			case 3://��Ա����
				break;
			case 4://��Ա
				$params['message_is_exp'] = array(0);
				break;
			case 5://����
				$params['message_is_exp'] = 1;
				break;
		}


		$this->response(0,Message::model()->lists($params));
	}


	/**
	 * ������Ϣ
	 * @param string @text ����
	 * @param int @exp �Ƿ�������Ϣ
	 * @param string @time ����ʱ��
	 *
	 * @return mixed json
	 */
	public function actionCreate()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,2)))
			$this->response(1000);
		$params = array(
			'exp' => intval(Yii::app()->request->getParam('exp',0)),
			'text' => Yii::app()->request->getParam('text',''),
			'time' => Yii::app()->request->getParam('time',date('Y-m-d H:i:s')),
		);

		if(empty($params['text']))
			$this->response(1006);

		$message = new Message();
		$message->user_id = Yii::app()->user->id;
		$message->message_text = $params['text'];
		$message->message_is_exp = intval($params['exp']);
		$message->message_time = time();

		if($message->save())
		{
			$this->response(0,$message->attr());
		}
		else
			$this->response(1001);
	}


	/**
	 * ������Ϣ
	 * @param int @id ��ϢID
	 *
	 * @return mixed json
	 */
	public function actionDelete()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,2)))
			$this->response(1000);
		$model = Message::model()->findByPk(intval(Yii::app()->request->getParam('id',0)));
		if($model && $model->delete())
		{
			$this->response(0);
		}
		else
			$this->response(1001);
	}

	/**
	 * ��Ļ��ͼ
	 * @param string $appkey ϵͳ����Ӧ��KEY
	 * @param string $token �û���¼��ϵͳ�����token
	 * @param string $avator ͷ��
	 */
	public function actionUpload()
	{
		$image = Yii::app()->request->getParam('image');
		if(!$image)
			$this->response(1006);
		$path =  '/snap/'.date('Ymd').'/';
		$dir  = SITE_UPLOAD. $path ;
		LUtil::mkdirs($dir);
		$filename  =  $path.date("His").floor(microtime() * 1000).'_'.LUtil::generateRandCode(4,4). '.jpg';//�ϴ��ļ�����չ��
		file_put_contents(SITE_UPLOAD.$filename, base64_decode($image));
		if(is_file(SITE_UPLOAD.$filename))
		{
			$this->response(0,array('url'=>Yii::app()->params->upload.$filename));
		}

		$this->response(1001);
	}
}