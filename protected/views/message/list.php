<?php
/**
 * var array $models
 */
$this->pageTitle = '聊天信息';

//print_r($models);exit;
foreach ($models['data'] as $model)
{
    echo '<div>'.date('Y-m-d H:i:s',intval($model['message_created'])).'<br>&nbsp;'. $model['message_text'].'</div>';
}
?>