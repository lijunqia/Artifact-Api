<?php
/**
 * var array $models
 */
$this->pageTitle = '公告信息';

?>

<table width="100%" responsive="true" summary="table">
    <tbody>
    <?php
    foreach ($models['data'] as $model)
    {
        ?>
        <tr responsive="true">
            <th align="left" scope="col"><?=$model['notice_created'];?></th>
        </tr>
        <tr valign="top">
            <td><?=$model['notice_body'];?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>