<?php
/**
 * var array $models
 */
$this->pageTitle = '聊天信息';


foreach ($models['data'] as $model)
{
    echo '<div>'.date('Y-m-d H:i:s',$model['message_time']).'<br>&nbsp;'. $model['message_text'].'</div>';
}
?>