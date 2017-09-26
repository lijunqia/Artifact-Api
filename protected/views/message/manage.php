<?php
/* @var $this SessionController */

/**
 * var array $models
 */
$this->pageTitle = '聊天记录';
?>
<style>
    table ,th,td{ border:1px solid #ddd;}
    th,td{ height:30px;}
    td img{ max-width:100%;}
</style>

<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl('message/manage',array('token'=>Yii::app()->request->getParam("token"))),
		'method'=>'get',
	)); ?>


    <div class="row">
        关键字：<?php echo CHtml::textField('q',Yii::app()->request->getParam("q"));?>
        时间：<?php
	    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
		    'attribute'=>'min_time',
		    'language'=>'zh_cn',
		    'name'=>'min_time',
		    'options'=>array(
			    'showAnim'=>'fold',
			    'showOn'=>'both',
//			    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
			    'buttonImageOnly'=>true,
			    'dateFormat'=>'yy-mm-dd',
		    ),
		    'htmlOptions'=>array(
			    'value'=>Yii::app()->request->getParam("min_time")
		    ),
	    ));

	    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
		    'attribute'=>'max_time',
		    'language'=>'zh_cn',
		    'name'=>'max_time',
		    'options'=>array(
			    'showAnim'=>'fold',
			    'showOn'=>'both',
//			    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
			    'buttonImageOnly'=>true,
			    'dateFormat'=>'yy-mm-dd',
		    ),
		    'htmlOptions'=>array(
		    ),
	    ));
        ?>
	    <?php echo CHtml::submitButton('查询'); ?>
    </div>

	<?php $this->endWidget(); ?>



	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl('message/batchdel',array('token'=>Yii::app()->request->getParam("token"))),
		'method'=>'get',
	)); ?>


    <div class="row">
        时间：<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'attribute'=>'start_time',
			'language'=>'zh_cn',
			'name'=>'start_time',
			'options'=>array(
				'showAnim'=>'fold',
				'showOn'=>'both',
//			    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
				'buttonImageOnly'=>true,
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
			),
		));

		$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'attribute'=>'end_time',
			'language'=>'zh_cn',
			'name'=>'end_time',
			'options'=>array(
				'showAnim'=>'fold',
				'showOn'=>'both',
//			    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
				'buttonImageOnly'=>true,
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
			),
		));
		?>
		<?php echo CHtml::submitButton('批量删除'); ?>
    </div>

	<?php $this->endWidget(); ?>
</div><!-- search-form -->

<table width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <th>#ID</th>
    <th>发言用户</th>
    <th>时间</th>
    <th>内容</th>
    <th width="30">操作</th>
    </thead>
    <tbody>
    <?php
    foreach ($models['data'] as $model)
    {
        ?>
        <tr responsive="true" id="tr_<?=$model['message_id']?>">
            <td align="left" scope="col"><?=$model['message_id'];?></td>
            <td align="left" scope="col">【<?=$model['user']['user_code'];?>】<?=$model['user']['user_name'];?></td>
            <td align="left" scope="col"><?=$model['message_time'];?></td>
            <td align="left" scope="col"><?=$model['message_text'];?></td>
            <td align="left" scope="col"><a href="javascript:delSession(<?=$model['message_id']?>)">删除</a> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script>
    function delSession(id)
    {
        if(confirm('确定要删除吗？')) {
            $.getJSON("<?=Yii::app()->createUrl('message/delete', array( 'token' => Yii::app()->request->getParam('token', '')));?>&id=" + id, function (result) {
                if (result.code == 0) {
                    $('#tr_' + id).remove();
//                window.location.reload();
                }
                else
                {
                    alert('删除失败')
                }
            });
        }
    }
</script>