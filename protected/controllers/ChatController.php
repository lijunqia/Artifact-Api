<?php

class ChatController extends Controller
{
	public function actionIndex()
	{
		$minid = intval(Yii::app()->request->getParam('min',0));
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

		if($to_user>0)
		{
			$condition .= ' and (user_id='.$to_user.' or chat_user_id='.$to_user.')';
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
		$chat_users = Chat::model()->findAll(array(
			'condition' => Chat::model()->getCondition($params),
			'order' => 'chat_created desc',
			'group' => 'user_id',
		));
		$ids = array();
		foreach($chat_users as $chat)
			if(!in_array($chat['user_id'],$ids))
			$ids[] = $chat['user_id'];

		if(count($ids)==0)
			$this->response(0,array('data'=>array()));
		$params = array(
			'user_id'=>$ids,
			'user_is_service'=>array(0),
		);
		$this->response(0,User::model()->all($params));
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
    public function actionCheck()
    {
        $minid = intval(Yii::app()->request->getParam('min',0));
        $to_user = intval(Yii::app()->request->getParam('to',0));
        $params = array(
            'other' => array(
                'page' => intval(Yii::app()->request->getParam('page',0)),
                'size' => intval(Yii::app()->request->getParam('size',10)),
                'order' => Yii::app()->request->getParam('order','chat_id desc'),
            ),
            '>'=>array('chat_id'=>$minid ,'chat_created'=>time()-60),
            'like' => array('chat_text'=>Yii::app()->request->getParam('q','')),
        );
        $condition = ' and chat_is_read=0 and ( user_id='.intval(Yii::app()->user->id).' or chat_user_id='.intval(Yii::app()->user->id).') ';

        if($to_user>0)
        {
            $condition .= ' and (user_id='.$to_user.' or chat_user_id='.$to_user.')';
        }
        $model = Chat::model();
        $condition = $model->getCondition($params).$condition;
        $count = $model->count($condition);
        $data = $model->find($condition);
        if($count)
            $this->response(0,array('count'=>$count,'id'=>$data->chat_id));
        else
            $this->response(1010);
    }

	/**
	 * APP
	 * @param string $appkey 系统分配应用KEY
	 * @param string $token 用户登录后系统分配的token
	 * @param string $avator 头像
	 */
	public function actionUploader()
	{
		//原版方式上传
		if (isset($_FILES) && !empty($_FILES)) {
			$type = Yii::app()->request->getParam('type');
			$to_user_id = Yii::app()->request->getParam('to',0);
			$data = LUtil::upfile('image', $type == 'sound'?'sound':'gallery');
			if (isset($data['file']))
			{
				$chat = new Chat();
				if($type == 'sound')
				{
					$text = '<span class="mui-icon mui-icon-mic" style="font-size: 18px;font-weight: bold;"></span><span class="play-state" url="'.base64_encode($data['url']).'">点击播放</span>';
					$chat->chat_media = $data['url'];
				}
				else
				{
					$text = '<img src="'.$data['url'].'" title="'.$data['title'].'" class="msg-content-image" data-preview-src="" data-preview-group="1">';
				}

				$chat->chat_media_type = $type;
				$chat->user_id = Yii::app()->user->id;
				$chat->chat_user_id = $to_user_id;//接收用户
				$chat->chat_text = $text;


				if($chat->save())
				{
					$this->response(0,$chat->attr());
				}
				else
					$this->response(1001);
			}

		}

		$this->response(1001);
	}
}