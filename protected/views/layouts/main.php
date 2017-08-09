<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <style>

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        div#content table,div#content th,div#content td {
            border: 1px solid #bbb;
        }

        td,th {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 8px;
            padding-left: 8px;
        }

        th {
            background-color: #ededed;
            color: #636363;
            text-align: left;
        }

        td {
            color: #2a2a2a;
            vertical-align: top;
        }

        table p:last-child {
            padding-bottom: 0;
        }

    </style>
</head>

<body>
	<?php echo $content; ?>
<a name="buttom"></a>
 <script language="JavaScript">
function myrefresh(){
    window.location.reload();
}
setTimeout('myrefresh()',5000); //指定1秒刷新一次
</script>
</body>
</html>
