<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_code')); ?>:</b>
	<?php echo CHtml::encode($data->user_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_password')); ?>:</b>
	<?php echo CHtml::encode($data->user_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_avatar')); ?>:</b>
	<?php echo CHtml::encode($data->user_avatar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_mobile')); ?>:</b>
	<?php echo CHtml::encode($data->user_mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_reg_time')); ?>:</b>
	<?php echo CHtml::encode($data->user_reg_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_reg_ip')); ?>:</b>
	<?php echo CHtml::encode($data->user_reg_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_expire')); ?>:</b>
	<?php echo CHtml::encode($data->user_expire); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_last_time')); ?>:</b>
	<?php echo CHtml::encode($data->user_last_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_last_ip')); ?>:</b>
	<?php echo CHtml::encode($data->user_last_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_login_num')); ?>:</b>
	<?php echo CHtml::encode($data->user_login_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_is_delete')); ?>:</b>
	<?php echo CHtml::encode($data->user_is_delete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_is_exp')); ?>:</b>
	<?php echo CHtml::encode($data->user_is_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_is_service')); ?>:</b>
	<?php echo CHtml::encode($data->user_is_service); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_remark')); ?>:</b>
	<?php echo CHtml::encode($data->user_remark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_created')); ?>:</b>
	<?php echo CHtml::encode($data->user_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_updated')); ?>:</b>
	<?php echo CHtml::encode($data->user_updated); ?>
	<br />

	*/ ?>

</div>