<?php

$class_name = get_class($model);
Yii::app()->clientScript->registerScript('re-install-date-picker', "
    $('#{$class_name}_add_time').addClass('form-control');
    function reinstallDatePicker(id, data) {
        $('#{$class_name}_add_time').datepicker();
    }
");
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $model->search(),
	'filter'=>$model,
	'template'=>'{items}{pager}',
	'emptyText'=>'当前没有数据！',
			'summaryText'=>'<button class="btn btn-default">第{page}页/共{pages}页</button>',
//			'itemsCssClass'=>'table table-striped table-bordered td-center',
//			'pagerCssClass'=>'data-page',
//			'summaryCssClass'=>'btn-group-sm',
	'pager'=>array(
		'class'=>'CLinkPager',
		'header'=>'',
		'firstPageLabel'=>'首页',
		'nextPageLabel'=>'»',
		'lastPageLabel'=>'末页',
		'prevPageLabel'=>'«',
	),
	'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
		array(
			'name' => 'role_id',
			'filter' => CHtml::listData(Role::model()->findAll(), "role_id", "role_name"),
			'value' => 'Role::model()->a($data->role_id)->role_name',
		),
		'user_code',
		'user_password',
		'user_name',
		'user_mobile'=>array(
			'htmlOptions'=>array('style'=>'width:40px;text-align:center;'),
			'name'=>'user_mobile',
			'type'=>'raw',
			'value'=>'CHtml::textField("user_mobile", $data->user_mobile)'
		),
		'user_expire'=>array(
			'name'=>'user_expire',
			'value'=>'$data->user_expire>0?date("Y-m-d",$data->user_expire):""',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'language'=>'zh-CN',
				'attribute'=>'user_expire',
				'htmlOptions' => array(
					'class' => 'form-control',
				),
				'defaultOptions' => array(
					'showOn' => 'focus',
					'dateFormat' => 'yy-mm-dd',
					'showOtherMonths' => true,
					'selectOtherMonths' => true,
					'changeMonth' => true,
					'changeYear' => true,
					'showButtonPanel' => true,
				)
			),
				true),
		),
		array(
			'name' => 'user_is_exp',
			'filter' => array('否','是'),
			'value' => '$data->yesOrNo($data->user_is_exp)',
		),
		array(
			'name' => 'user_is_service',
			'filter' => array('否','是'),
			'value' => '$data->yesOrNo($data->user_is_service)',
		),
		'user_reg_time'=>array(
			'name'=>'user_reg_time',
			'value'=>'$data->user_reg_time>0?date("Y-m-d",$data->user_reg_time):""',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'language'=>'zh-CN',
				'attribute'=>'user_reg_time',
				'htmlOptions' => array(
					'class' => 'form-control',
				),
				'defaultOptions' => array(
					'showOn' => 'focus',
					'dateFormat' => 'yy-mm-dd',
					'showOtherMonths' => true,
					'selectOtherMonths' => true,
					'changeMonth' => true,
					'changeYear' => true,
					'showButtonPanel' => true,
				)
			),
				true),
		),
		array(
			'header'=>'操作',
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>"js:'ID为 '+$(this).parent().parent().children(':first-child').text()+' 的记录将被删除，确定删除？'",
		)
	)
));	
?>
