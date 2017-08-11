<?php
/**
 * var array $models
 */
$this->pageTitle = '聊天信息';

?>
<style>
    *, *:before, *:after {
        box-sizing: border-box;
    }
    body, html {
        height: 100%;
        /*overflow: hidden;*/
    }
    body, ul {
        margin: 0;
        padding: 0;
    }
    body {
        color: #4d4d4d;
        font: 14px/1.4em 'Helvetica Neue', Helvetica, 'Microsoft Yahei', Arial, sans-serif;
        /*background: #f5f5f5 url('/images/bg.jpg') no-repeat center;*/
        background-size: cover;
        font-smoothing: antialiased;
    }
    ul {
        list-style: none;
    }
    .m-message {
        padding: 10px 15px;
        /*overflow-y: scroll;*/
    }
    .m-message li {
        margin-bottom: 15px
    }
    .m-message .time {
        margin: 7px 0;
        text-align: center
    }
    .m-message .time>span {
        display: inline-block;
        padding: 0 18px;
        font-size: 9pt;
        color: #fff;
        border-radius: 2px;
        background-color: #dcdcdc
    }
    .m-message .avatar {
        float: left;
        margin: 0 10px 0 0;
        border-radius: 3px
    }
    .m-message .text {
        display: inline-block;
        position: relative;
        padding: 0 10px;
        max-width: calc(100% - 40px);
        min-height: 30px;
        line-height: 2.5;
        font-size: 9pt;
        text-align: left;
        word-break: break-all;
        background-color: #fafafa;
        border-radius: 4px
    }
    .m-message .text:before {
        content: " ";
        position: absolute;
        top: 9px;
        right: 100%;
        border: 6px solid transparent;
        border-right-color: #fafafa
    }
    .m-message .self {
        text-align: right
    }
    .m-message .self .avatar {
        float: right;
        margin: 0 0 0 10px
    }
    .m-message .self .text {
        background-color: #b2e281;
        text-align: right
    }
    .m-message .self .text:before {
        right: inherit;
        left: 100%;
        border-right-color: transparent;
        border-left-color: #b2e281
    }
</style>
<div class="m-message">
    <ul id="msg">

        <?php
        $maxid = 0;
        foreach ($models['data'] as $model)
        {
            if($maxid < $model['message_id'])
                $maxid = $model['message_id'];
            if(Yii::app()->user->id != $model['user_id']) {

                ?>

                <li>
                    <p class="time"><span><?= $model['message_created']; ?></span></p>
                    <div class="main"><img class="avatar" width="30" height="30" src="/images/2.png">
                        <span class="text"><?= htmlspecialchars_decode($model['message_text']); ?></span>
                    </div>
                </li>

                <?php
            }
            else {
                ?>
                <li>
                    <p class="time"><span><?= $model['message_created']; ?></span></p>
                    <div class="main self"><img class="avatar" width="30" height="30" src="/images/1.jpg">
                        <span class="text"><?= htmlspecialchars_decode($model['message_text']); ?></span>
                    </div>
                </li>

                <?php
            }
        }
        ?>
    </ul>
</div>
<a id="buttom"></a>
<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script>
    window.onerror=function(){return true;}
    var maxid = <?=$maxid;?>;
    function get_message()
    {
        $.getJSON("/message/index?token=<?=Yii::app()->request->getParam('token','')?>&type=<?=Yii::app()->request->getParam('type',0)?>&min="+maxid,function(result){

            if(result.code == 0 && result.items.length>0) {
                $.each(result.items, function (idx, obj) {
                    var  img='2.png';
                    if(maxid < obj.message_id)
                        maxid = obj.message_id;
                    var html = '<li><p class="time"><span>' +
                        obj.message_created + '</span></p><div class="main ';
                    if (obj.user_id == <?=Yii::app()->user->id;?>)
                    {
                        html += 'self';
                        img='1.jpg';
                    }
                    html += '"><img class="avatar" width="30" height="30" src="/images/'+img+'"><span class="text">' + obj.message_text + '</span></div></li>';
                    $("#msg").append(html);
                    $("html, body").animate({scrollTop: $("#buttom").offset().top }, {duration: 100,easing: "swing"});

                });

            }
        });
    }

    $(document).ready(function(){
        setInterval('get_message()',3000);
    });
</script>
