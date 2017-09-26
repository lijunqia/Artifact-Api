<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = '修改用户';


?>

<div id="mainmenu">
	<?php $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'用户列表', 'url'=>array('user/list', 'token'=>Yii::app()->request->getParam("token"))),
			array('label'=>'添加用户', 'url'=>array('user/edit', 'token'=>Yii::app()->request->getParam("token"))),
		),
	)); ?>
</div>

<div class="container">
    <div id="content">
<h1>修改用户 <?php echo $model->user_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

    </div><!-- content -->
</div>