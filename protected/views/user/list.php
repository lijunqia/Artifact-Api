<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle = '用户管理';

?>


<div id="mainmenu">
	<?php $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'用户列表', 'url'=>array('user/list', 'token'=>Yii::app()->request->getParam("token"))),
			array('label'=>'添加用户', 'url'=>array('user/edit', 'token'=>Yii::app()->request->getParam("token"))),
		),
	)); ?>
</div>
<?php
$class_name = get_class($model);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
    function reinstallDatePicker(id, data) {
        $('#{$class_name}_user_expire').datepicker();
        $('#{$class_name}_user_reg_time').datepicker();
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
		'user_code',
		'user_password',
		'user_name',
		'user_mobile',
		array(
			'name' => 'role_id',
			'filter' => CHtml::listData(Role::model()->findAll(), "role_id", "role_name"),
			'value' => 'Role::model()->a($data->role_id)->role_name',
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
			'deleteConfirmation'=>"js:'账号为 【'+$(this).parent().parent().children(':first-child').text()+'】 的记录将被删除，确定删除？'",
			'template'=>'{edit} {view} {delete}',
			'buttons'=>array
			(
				'edit' => array
				(
					'label'=>'修改',
					'url'=>'Yii::app()->createUrl("user/edit", array("id"=>$data->user_id,"token"=>Yii::app()->request->getParam("token")))',
				),
				'view' => array
				(
					'label'=>'查看',
					'url'=>'Yii::app()->createUrl("user/view", array("id"=>$data->user_id,"token"=>Yii::app()->request->getParam("token")))',
				),
				'delete' => array
				(
					'label'=>'删除',
					'url'=>'Yii::app()->createUrl("user/delete", array("id"=>$data->user_id,"token"=>Yii::app()->request->getParam("token")))',
				),
			),
		)
	)
));

?>
