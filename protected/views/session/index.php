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
    <th>用户</th>
    <th>IP</th>
    <th>地区</th>
    <th>登入时间</th>
    </thead>
    <tbody>
    <?php
    foreach ($models['data'] as $model)
    {
        ?>
        <tr responsive="true">
            <td align="left" scope="col"><?=$model['user']['user_name'];?></td>
            <td align="left" scope="col"><?=$model['session_ip'];?></td>
            <td align="left" scope="col"><?=$model['session_area'];?></td>
            <td align="left" scope="col"><?=$model['session_visit_time'];?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>