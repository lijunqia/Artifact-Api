<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	
	public function init()
	{
		parent::init();
		Yii::app()->user->getState('user',new User());
		Yii::app()->user->getState('session',new Session());
        $noVerify = array('site');

		if(!in_array(Yii::app()->controller->id,$noVerify))
		{
			$token = Yii::app()->request->getParam('token','');
			if(!$token || !Session::model()->verify($token))
				$this->response(1004);
		}
	}

	/**
	 * 返回响应信息,格式JOSN
	 * @status int 状态码,
	 * @status array 输出数据,
	 * @status array 附加信息,
	 * @items string 数组
	 */
	protected function response($status = 0, $items = array(),$msg = '')
	{
		header('Content-type: application/json');
        $items = $this->replaceNull($items);
		if(!$msg)
			$msg = Status::item($status);
		$data = array('code'=>$status,'message'=>$msg);

		if(isset($items['extra']) )
		{
			$data['extra'] = $items['extra'];
		}

		if(isset($items['data']))
			$data['items']=$items['data'];
		else
			$data['items']=$items;

		echo json_encode($data);
		Yii::app()->end();
	}

    /**
     * 将 null 换为''
     * @param array $data
     *
     * @return mixed
     */
    public function replaceNull($data)
    {
	    if(!is_array($data))return array();
        foreach($data as $k=>$v)
        {
            if(is_array($v))
                $data[$k] = $this->replaceNull($v);
            elseif($v === null)
                $data[$k] = '';
        }

        return $data;
    }

}