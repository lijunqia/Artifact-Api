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
            'models'=>Session::model()->lists(array()),
        ));
    }

}