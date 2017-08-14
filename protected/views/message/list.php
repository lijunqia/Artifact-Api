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
        background-color: #ff9e6f;
        border-radius: 4px
    }
    .m-message .text:before {
        content: " ";
        position: absolute;
        top: 3px;
        right: 100%;
        border: 6px solid transparent;
        border-right-color: #ff9e6f
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
    .m-message .text img,.m-message .self .text img {
       max-width: 100%;
    }
    .m-message .name {
        font-size: 12px;
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
                        <div class="name"><?= $model['user']['user_name']; ?></div>
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
                        <div class="name"><?= $model['user']['user_name']; ?></div>
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
    var msg = '';
    function get_message()
    {
        $.getJSON("/message/index?token=<?=Yii::app()->request->getParam('token','')?>&type=<?=Yii::app()->request->getParam('type',0)?>&min="+maxid,function(result){

            var sw = false;
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
                    html += '"><img class="avatar" width="30" height="30" src="/images/'+img+'"><div class="name">' + obj.user.user_name + '</div><span class="text">' + obj.message_text + '</span></div></li>';
                    $("#msg").append(html);
                    $("html, body").animate({scrollTop: $("#buttom").offset().top }, {duration: 100,easing: "swing"});
                    if(obj.user.role_id<=3)
                        sw=true;
                });

            }
            else if(result.code == 1004)
            {
                var html = '<li><p class="time"><span>' +
                    getDateTime() + '</span></p><div class="main"><img class="avatar" width="30" height="30" src="/images/2.png"><span class="text">登录信息已过期，请退出重新登录</span></div></li>';
                $("#msg").append(html);
                $("html, body").animate({scrollTop: $("#buttom").offset().top }, {duration: 100,easing: "swing"});
                window.clearInterval(msg);
                sw=true;
            }

            if(sw)
            {
                window.external.showWindow();
            }
        });
    }
    //yyyy-MM-dd HH:mm:SS
    function getDateTime() {
        d = new Date();
        var year = d.getFullYear();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var hh = d.getHours();
        var mm = d.getMinutes();
        var ss = d.getSeconds();
        return year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
    }
    $(document).ready(function(){
        msg = setInterval('get_message()',3000);
    });
</script>
