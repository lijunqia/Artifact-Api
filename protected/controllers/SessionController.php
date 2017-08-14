<?php

class SessionController extends Controller
{
    public function actionIndex()
    {
        $params = array(
            'other' => array(
                'page' => intval(Yii::app()->request->getParam('page',0)),
                'size' => intval(Yii::app()->request->getParam('size',100)),
                'order' => Yii::app()->request->getParam('order','session_visit_time desc'),
            ),
        );

        if(Yii::app()->user->getState('user')->role_id>3)
            Yii::app()->end();

        $this->render('index',array(
            'models'=>Session::model()->lists($params),
        ));
    }

    /**
     * 删除
     * @param int @id 信息ID
     *
     * @return mixed json
     */
    public function actionDelete($id)
    {
        if(!$id || !in_array(Yii::app()->user->getState('user')->role_id ,array(1,2)))
            $this->response(1000);
        $model = Session::model()->findByPk($id);
        if($model && $model->delete())
        {
            $this->response(0);
        }
        else
            $this->response(1001);
    }

}