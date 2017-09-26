<?php
/* @var $this UserController */
/* @var $model User */


$this->pageTitle = '查看用户';


?>

<div id="mainmenu">
	<?php $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'用户列表', 'url'=>array('user/list', 'token'=>Yii::app()->request->getParam("token"))),
			array('label'=>'添加用户', 'url'=>array('user/edit', 'token'=>Yii::app()->request->getParam("token"))),
			array('label'=>'查看用户', 'url'=>array('user/view','id'=>$model->user_id, 'token'=>Yii::app()->request->getParam("token"))),
		),
	)); ?>
</div>

<div class="container">
    <div id="content">
<h1>查看用户 #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		array(
			'name'=>'role_id',
			'value'=>Role::item($model->role_id)
		),
		'user_parent_id',
		'user_code',
		'user_password',
		'user_avatar',
		'user_name',
		'user_mobile',
		'user_email',
		array(
			'name'=>'user_reg_time',
			'value'=>date('Y-m-d H:i:s',$model->user_reg_time)
		),
		'user_reg_ip',
		array(
			'name'=>'user_expire',
			'value'=>date('Y-m-d H:i:s',$model->user_expire)
		),
		array(
			'name'=>'user_last_time',
			'value'=>date('Y-m-d H:i:s',$model->user_last_time)
		),
		'user_last_ip',
		'user_login_num',
		array(
			'name'=>'user_is_delete',
			'value'=>$model->yesOrNo($model->user_is_delete)
		),
		array(
			'name'=>'user_is_exp',
			'value'=>$model->yesOrNo($model->user_is_exp)
		),
		array(
			'name'=>'user_is_service',
			'value'=>$model->yesOrNo($model->user_is_service)
		),
		'user_remark',
		'user_created',
		'user_updated',
	),
)); ?>

    </div><!-- content -->
</div>