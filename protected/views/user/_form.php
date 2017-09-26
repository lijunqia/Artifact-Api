<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<style>
    div.form label{display: inline-block; width: 100px; padding-right: 20px;}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<input type="hidden" name="token" value="<?=Yii::app()->request->getParam('token');?>">
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php echo $form->dropDownList($model,'role_id',Role::model()->items()); ?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_code'); ?>
		<?php echo $form->textField($model,'user_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'user_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password'); ?>
		<?php echo $form->textField($model,'user_password',array('size'=>20,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'user_password'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>20,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_mobile'); ?>
		<?php echo $form->textField($model,'user_mobile',array('size'=>20,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'user_mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_expire'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'user_expire',
			'options'=> array(
				'showAnim'=>'fold',
				'dateFormat'=>'yy-mm-dd',
				'changeMonth' => true,
				'changeYear' => true,
				'dayNames' => array('周一','周二','周三','周四','周五','周六','周日'),
				'dayNamesMin' => array('日','一','二','三','四','五','六'),
				'monthNamesShort' => array('一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'),
				'showMonthAfterYear' => true,
			),
			'htmlOptions'=>array(
				'readonly' => true,
			),

		));  ?>
		<?php echo $form->error($model,'user_expire'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_is_delete'); ?>
		<?php echo $form->radioButtonList($model,'user_is_delete', array('0'=>'否','1'=>'是'),array('separator'=>' ')); ?>
		<?php echo $form->error($model,'user_is_delete'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_is_exp'); ?>
		<?php echo $form->radioButtonList($model,'user_is_exp', array('0'=>'否','1'=>'是'),array('separator'=>' ')); ?>
		<?php echo $form->error($model,'user_is_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_is_service'); ?>
		<?php echo $form->radioButtonList($model,'user_is_service', array('0'=>'否','1'=>'是'),array('separator'=>' ')); ?>
		<?php echo $form->error($model,'user_is_service'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_remark'); ?>
		<?php echo $form->textField($model,'user_remark',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_remark'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->