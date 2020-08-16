<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title></title>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <link rel="bookmark" href="./favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/d.css" type="text/css" />
</head>
<body>
<div id="head">
    <div id="head1">
        <a href="..">首页</a>
    </div>
    <div id="head2">
        <form action="./dx.php" method='POST' onsubmit="return checkform(this);">
            <p>名称：<input id="ipt" type="text" name="wd" autofocus value="">
            <input type="submit" value="检索"></p>
        </form>
        <form action="./dx.php" method='POST' onsubmit="return checkform(this);">
            <p>地址：<input id="ipt" type="text" name="url" autofocus value="">
            <input type="submit" value="分析"></p>
        </form>
</div></div>
</body>
</html>