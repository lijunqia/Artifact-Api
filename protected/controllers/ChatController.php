<?php

class ChatController extends Controller
{
	public function actionIndex()
	{
		$minid = intval(Yii::app()->request->getParam('minid',0));
		$to_user = intval(Yii::app()->request->getParam('to',0));
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',10)),
				'order' => Yii::app()->request->getParam('order','chat_id'),
			),
			'>'=>array('chat_id'=>$minid ,'chat_created'=>time()-604800),
			'like' => array('chat_text'=>Yii::app()->request->getParam('q','')),
		);
		$condition = ' and ( user_id='.intval(Yii::app()->user->id).' or chat_user_id='.intval(Yii::app()->user->id).') ';

		if($to_user>0  && Yii::app()->user->getState('user')->user_is_service)
		{
			$condition .= ' and chat_user_id='.$to_user;
		}

		$this->response(0,Chat::model()->lists($params,$condition));
	}

	/**
	 * 发给客服的用户列表
	 *
	 * @return mixed json
	 */
	public function actionUser()
	{
		if(!Yii::app()->user->getState('user')->user_is_service)
			$this->response(1000);

		$params = array(
			'chat_user_id'=>Yii::app()->user->id,
			'other' => array(
				'group' => Yii::app()->request->getParam('group','user_id'),
			),
		);

		$this->response(0,Chat::model()->all($params));
	}

	/**
	 * 发布信息
	 * @param string @text 内容
	 * @param int @exp 是否体验信息
	 * @param string @time 发布时间
	 *
	 * @return mixed json
	 */
	public function actionCreate()
	{
		$params = array(
			'chat_user_id' => intval(Yii::app()->request->getParam('to',0)),
			'text' => Yii::app()->request->getParam('text',''),
			'time' => Yii::app()->request->getParam('time',date('Y-m-d H:i:s')),
		);

		if(empty($params['text']))
			$this->response(1006);

		$chat = new Chat();
		$chat->user_id = Yii::app()->user->id;
		$chat->chat_user_id = $params['chat_user_id'];//接收用户
		$chat->chat_text = $params['text'];

		if($chat->save())
		{
			$this->response(0,$chat->attr());
		}
		else
			$this->response(1001);
	}


	/**
	 * 发布信息
	 * @param int @id 信息ID
	 *
	 * @return mixed json
	 */
	public function actionDelete()
	{
		if(Yii::app()->user->getState('user')->role_id==1)
			$this->response(1000);
		$model = Chat::model()->findByPk(intval(Yii::app()->request->getParam('id',0)));
		if($model && $model->delete())
		{
			$this->response(0);
		}
		else
			$this->response(1001);
	}

	/**
	 * 屏幕截图
	 * @param string $appkey 系统分配应用KEY
	 * @param string $token 用户登录后系统分配的token
	 * @param string $avator 头像
	 */
	public function actionUpload()
	{
		$image = Yii::app()->request->getParam('image');
		if(!$image)
			$this->response(1006);
		$path =  '/chat/'.date('Ymd').'/';
		$dir  = SITE_UPLOAD. $path ;
		LUtil::mkdirs($dir);
		$filename  =  $path.date("His").floor(microtime() * 1000).'_'.LUtil::generateRandCode(4,4). '.jpg';//上传文件的扩展名
		file_put_contents(SITE_UPLOAD.$filename, base64_decode($image));
		if(is_file(SITE_UPLOAD.$filename))
		{
			$this->response(0,array('url'=>Yii::app()->params->upload.$filename));
		}

		$this->response(1001);
	}
}