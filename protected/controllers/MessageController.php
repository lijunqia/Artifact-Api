<?php

class MessageController extends Controller
{
	public function actionIndex()
	{
		$minid = intval(Yii::app()->request->getParam('min',0));
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',20)),
				'order' => Yii::app()->request->getParam('order','message_id '.($minid?'':' DESC')),
			),
            'message_type'=>intval(Yii::app()->request->getParam('type',0)),
			'>'=>array('message_id'=> $minid,'message_created'=>time()-604800),
			'like' => array('message_text'=>Yii::app()->request->getParam('q','')),
		);
//		switch(Yii::app()->user->getState('user')->role_id)
//		{
//			case 1://管理员
//			case 2://信息管理
//			case 3://会员管理
//				break;
//			case 4://会员
//				$params['message_is_exp'] = array(0);
//				break;
//			case 5://体验
//				$params['message_is_exp'] = 1;
//				break;
//		}

		$data = Message::model()->lists($params);
		if(!$minid)
			$data['data'] = array_reverse($data['data']);
		$this->response(0,$data);
	}

    public function actionList()
    {
    	$this->layout  = 'chat';
        $minid = intval(Yii::app()->request->getParam('min',0));
        $params = array(
            'other' => array(
                'page' => intval(Yii::app()->request->getParam('page',0)),
                'size' => intval(Yii::app()->request->getParam('size',100)),
                'order' => Yii::app()->request->getParam('order','message_id '.($minid?'':' DESC')),
            ),
            'message_type'=>array(intval(Yii::app()->request->getParam('type',0))),
            '>'=>array('message_id'=> $minid,'message_created'=>time()-604800),
            'like' => array('message_text'=>Yii::app()->request->getParam('q','')),
        );
//        switch(Yii::app()->user->getState('user')->role_id)
//        {
//            case 1://管理员
//            case 2://信息管理
//            case 3://会员管理
//                break;
//            case 4://会员
//                $params['message_is_exp'] = array(0);
//                break;
//            case 5://体验
//                $params['message_is_exp'] = 1;
//                break;
//        }
		$data = Message::model()->lists($params);
		if(!$minid)
			$data['data'] = array_reverse($data['data']);

        $this->render('list',array(
            'models'=>$data,
        ));
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
		if(Yii::app()->user->getState('user')->role_id >= 5)
			$this->response(1000);
		$params = array(
            'exp' => intval(Yii::app()->request->getParam('exp',0)),
            'type' => intval(Yii::app()->request->getParam('type',0)),
			'text' => Yii::app()->request->getParam('text',''),
			'time' => Yii::app()->request->getParam('time',date('Y-m-d H:i:s')),
		);

		if(empty($params['text']))
			$this->response(1006);

		$message = new Message();
		$message->user_id = Yii::app()->user->id;
		$message->message_text = $params['text'];
        $message->message_is_exp = intval($params['exp']);
        $message->message_type = intval($params['type']);
		$message->message_time = time();

		if($message->save())
		{
			$this->response(0,$message->attr());
		}
		else
			$this->response(1001);
	}


	/**
	 * 删除信息
	 * @param int @id 信息ID
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
		$path =  '/snap/'.date('Ymd').'/';
		$dir  = SITE_UPLOAD. $path ;
		LUtil::mkdirs($dir);
		$filename  =  $path.date("His").floor(microtime() * 1000).'_'.LUtil::generateRandCode(4,4). '.jpg';//上传文件的扩展名
		file_put_contents(SITE_UPLOAD.$filename, base64_decode($image));
		if(is_file(SITE_UPLOAD.$filename))
		{
			$this->response(0,array('url'=>Yii::app()->request->hostInfo . Yii::app()->params->upload.$filename));
		}

		$this->response(1001);
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
			$data = LUtil::upfile('image', $type == 'sound'?'sound':'gallery');
			if (isset($data['file']))
			{
				$message = new Message();
				if($type == 'sound')
				{
					$text = '<span class="mui-icon mui-icon-mic" style="font-size: 18px;font-weight: bold;"></span><span class="play-state" url="'.base64_encode($data['url']).'">点击播放</span>';
					$message->message_media = $data['url'];
				}
				else
				{
					$text = '<img src="'.$data['url'].'" title="'.$data['title'].'" class="msg-content-image" data-preview-src="" data-preview-group="1">';
				}

				$message->message_media_type = $type;
				$message->user_id = Yii::app()->user->id;
				$message->message_text = $text;
				$message->message_time = time();

				if($message->save())
				{
					$this->response(0,$message->attr());
				}
				else
					$this->response(1001);
			}

		}

		$this->response(1001);
	}
	public function actionManage()
	{
		$params = array(
			'other' => array(
				'page' => intval(Yii::app()->request->getParam('page',0)),
				'size' => intval(Yii::app()->request->getParam('size',100)),
				'order' => Yii::app()->request->getParam('order','message_time desc'),
			),
			'like' => array('message_text'=>Yii::app()->request->getParam('q','')),
		);

		if(Yii::app()->user->getState('user')->role_id>3)
			Yii::app()->end();

		$start_time = Yii::app()->request->getParam('min_time');
		$end_time  = Yii::app()->request->getParam('max_time');
		if($start_time && $end_time)
			$params['between'] = array('message_time'=>array('min'=>strtotime($start_time),'max'=>strtotime($end_time.' 23:59:59')));
		$this->render('manage',array(
			'models'=>Message::model()->lists($params),
		));
	}

	/**
	 * 删除信息
	 * @param int @id 信息ID
	 *
	 * @return mixed json
	 */
	public function actionBatchdel()
	{
		if(!in_array(Yii::app()->user->getState('user')->role_id ,array(1,2)))
			$this->response(1000);
		$start_time = Yii::app()->request->getParam('start_time');
		$end_time  = Yii::app()->request->getParam('end_time');
		if($start_time && $end_time)
			if(Message::model()->deleteAll('message_time between '.strtotime($start_time).' and '.strtotime($end_time.' 23:59:59')))
			{
				$this->response(0);
			}

			$this->response(1001);
	}

}