<?php
/**
 * var array $models
 */
$this->pageTitle = '聊天信息';

?>
<table width="100%" responsive="true" summary="table">
    <tbody>
    <?php
    foreach ($models['data'] as $model)
    {
    ?>
    <tr responsive="true">
        <th align="left" scope="col"><?=$model['message_created'];?></th>
    </tr>
    <tr valign="top">
        <td><?=$model['message_text'];?></td>
    </tr>
    <?php
    }
    ?>
    </tbody>
</table>