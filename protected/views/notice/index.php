<?php
/**
 * var array $models
 */
$this->pageTitle = '公告信息';

foreach ($models['data'] as $model)
{
    echo '<div>'.date('Y-m-d H:i:s',$model['notice_created']).'<br>&nbsp;'. $model['notice_body'].'</div>';
}
?>
