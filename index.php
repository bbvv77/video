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
<?php
date_default_timezone_set("Asia/Shanghai");
if(isset($_COOKIE['search'])){
    $searchs = unserialize($_COOKIE['search']);
    print_r("<div><form action='./dx.php' method='POST'><p>继续上一次搜素<input type='hidden' type='text' name='wd' value=".$searchs[0]."> <input id='ipt' onmousemove='red(this)' onmouseout='black(this)' type='submit' value=".$searchs[0].">".date('Y/m/d/H:i',$searchs[1])."</p>".$searchs[3]."</form></div>");
}
if(isset($_COOKIE['dt'])){
    $dt = unserialize($_COOKIE['dt']);
    $n = $dt[1];
    $file="./data/".$dt[0].".p";  //读出缓存 
    if(file_exists($file)){
        $handle=fopen($file,'r');
        $array=unserialize(fread($handle,filesize($file)));
        print_r("<div><form action=\"./play.php\" method='POST'><p>继续上一次观看");
        print_r("<input type=\"hidden\" name=\"wd\" value=".$dt[0].">");
        print_r("<input type=\"hidden\" name=\"id\" value=".$n.">");
        if(isset($_COOKIE['jishu'])){
            print_r("<input type=\"hidden\" name=\"js\" value=".$_COOKIE['jishu'].">");
        }
        print_r("<input id='ipt' onmousemove='red(this)' onmouseout='black(this)' type=\"submit\" value=".$array[$n]['title'].@$array[$n]["tag"][$_COOKIE['jishu']]."></p></form></div>");
        
    }
}
?>
</body>
</html>
