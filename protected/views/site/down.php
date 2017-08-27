<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<style>
    *{padding:0px; margin:0px}
    body,html{
        height: 100%;
        width: 100%;
    }
    body{
        background-image: url(/images/bg.png);
        background-repeat: no-repeat;
        background-size: 100% auto;
        background-position: center bottom;
    }
    img{
        display: block;
        margin-right: auto;
        margin-left: auto;
        padding-top: 100px;
        height: 150px;
        width: 150px;
    }
    .btn{
    }
    .btn a{
        border-radius: 6px;
        display: block;
        height: 60px;
        width: 80%;
        margin-right: auto;
        margin-left: auto;
        line-height: 60px;
        text-align: center;
        background-color: #E0403D;
        font-family: "微软雅黑";
        color: #FFF;
        text-decoration: none;
        font-size: 24px;
        background-image: url(/images/icon.svg);
        background-repeat: no-repeat;
        background-size: 32px 32px;
        background-position: 10% center;

    }
    .txt{
        text-align: center;
        line-height: 80px;
    }
    .btn2 a{
        border-radius: 6px;
        display: block;
        height: 60px;
        width: 80%;
        margin-right: auto;
        margin-left: auto;
        line-height: 60px;
        text-align: center;
        background-color: #E0403D;
        font-family: "微软雅黑";
        color: #FFF;
        text-decoration: none;
        font-size: 24px;
        background-image: url(/images/iphone.svg);
        background-repeat: no-repeat;
        background-size: 32px 32px;
        background-position: 10% center;

    }
</style>


<div class="txt">APP下载</div>
<div class="btn"><a href="/upload/app.apk">Android下载</a></div>
