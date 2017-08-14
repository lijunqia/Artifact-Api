<?php
/* @var $this SessionController */

/**
 * var array $models
 */
$this->pageTitle = '在线用户';
?>
<style>
    table ,th,td{ border:1px solid #ddd;}
    th,td{ height:30px;}
</style>
<table width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <th>账号</th>
    <th>姓名</th>
    <th>IP</th>
    <th>地区</th>
    <th>登入时间</th>
    <th>操作</th>
    </thead>
    <tbody>
    <?php
    foreach ($models['data'] as $model)
    {
        ?>
        <tr responsive="true">
            <td align="left" scope="col"><?=$model['user']['user_code'];?></td>
            <td align="left" scope="col"><?=$model['user']['user_name'];?></td>
            <td align="left" scope="col"><?=$model['session_ip'];?></td>
            <td align="left" scope="col"><?=$model['session_area'];?></td>
            <td align="left" scope="col"><?=$model['session_visit_time'];?></td>
            <td align="left" scope="col"><a href="javascript:delSession(<?=$model['user_id']?>)">删除</a> </td>
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
        $.getJSON("<?=Yii::app()->createUrl('session/delete',array('id'=>$model['user_id'],'token'=>Yii::app()->request->getParam('token','')));?>&id="+id,function(result){
            if(result.code==0)
            {
                window.location.reload();
            }
        });
    }
</script>