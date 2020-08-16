<a href="..">回到首页</a>
<?php
// 错误页
set_time_limit(0);
ob_implicit_flush();
if($_GET['error_code']=='1'){
    echo '<h2>wd未检索过</h2><p>请重新检索 名称</p>
    <form action="./dx.php" method="POST" onsubmit="return checkform();">
        <p>关建字：<input id="ipt" type="text" name="wd" autofocus value='.$_GET['wd'].'>
        <input type="submit" value="检索"></p>
    </form>';
}
if($_GET['error_code']=='2'){
    echo '<h2>id不存在</h2><p>请检查 是第几个检索结果</p>
    <form action="./dx.php" method="POST" onsubmit="return checkform();">
        <p>ID：<input id="ipt" type="text" name="wd" autofocus value='.$_GET['wd'].'>
        <input type="submit" value="检索"></p>
    </form>';
}
if($_GET['error_code']=='3'){
    echo '<h2>js不存在</h2><p>请检查 是第几</p>
    <form action="./dx.php" method="POST" onsubmit="return checkform();">
        <p>关建字：<input id="ipt" type="text" name="wd" autofocus value='.$_GET['wd'].'>
        <input type="submit" value="检索"></p>
    </form>';
}
if($_GET['error_code']=='4'){
    echo '<h2>地址有误</h2><p>请检查 输入的是否是正确的地址</p><p>可能是暂不支持，有问题请反馈</p>
    <form action="./dx.php" method="POST" onsubmit="return checkform();">
        <p>地址：<input id="ipt" type="text" name="url" autofocus value='.$_GET['url'].'>
        <input type="submit" value="检索"></p>
    </form>';
}
if($_GET['error_code']=='5'){
    echo '<h2>地址 不 支 持</h2><p>你输入的地址 暂不支持</p><p>暂时只支持正版网站</p>
    <form action="./dx.php" method="POST" onsubmit="return checkform();">
        <p>地址：<input id="ipt" type="text" name="url" autofocus value='.$_GET['url'].'>
        <input type="submit" value="检索"></p>
    </form>';
}
?>