<?php
if(array_key_exists("wd", $_POST)|array_key_exists("wd", $_GET)){
    if(isset($_POST["wd"])){$name = $_POST["wd"];}else{$name = $_GET["wd"];}
    preg_match_all('/https?:\/\/.*/',$name,$jx);  // 判断输入的是url
    if(isset($jx[0][0])){
        header("Location: ./dx.php?url=".$name);
        exit();
    }
    $js = 0;
}else{
    if(array_key_exists("url", $_POST)|array_key_exists("url", $_GET)){
        if(isset($_POST["url"])){$jx = $_POST["url"];}else{$jx = $_GET["url"];}
        preg_match_all('/https?:\/\/.*/',$jx,$jx1);  // 确保输入的是正确的url
        if(!isset($jx1[0][0])){
            $jx = "https://".$jx;
        }
        $url = array("/iqiyi.com\/.+/","/v.qq.com\/.+/","/v.youku.com\/.+/","/v.pptv.com\/.+/","/mgtv.com\/.+/");
        for($i=0;$i<sizeof($url);$i++){
            preg_match_all($url[$i],$jx,$py);
            if(isset($py[0][0])){
                $f = 1;
            }
        }
        if($f!=1){
            // url有误或者暂不支持
            header("Location: ./error.php?error_code=5&url=".$jx);
            exit();
        }
        $html = file_get_contents($jx);
        preg_match_all('/<title>(.*?)<\/title>/',$html,$py1);
        if(isset($py1[1][0])){
            $py1=$py1[1][0];
            $teshu=array("","-","_");
            for($i=0;$i<sizeof($teshu);$i++){
                $py1=str_replace($teshu[$i],"",$py1);
            }
            $name = $py1;
            //几种情况  第1季xxx 第1集 第22期xx
            preg_match_all('/(.*?)第/',$py1,$py2);
            if(isset($py2[1][0])){
                $name = $py2[1][0];
            }
            preg_match_all('/第([0-9]*?)集/',$py1,$py2);
            if(isset($py2[1][0])){
                $js = $py2[1][0]-1;
            }
            else{
                $js = 0;
            }
        }
        else{
            // url有误或者暂不支持
            header("Location: ./error.php?error_code=4&url=".$jx);
            exit();
        }
    }
    else{
        header("Location: ..");
        exit();
    }
}
$teshu=array(array(",","!",":"),array("，","！","："),array("(",")","普通话","粤语","版","[","]","《","》","\"","\'"," "));  // 0替换为1，2删除
for($i=0;$i<sizeof($teshu[0]);$i++){
    $name=str_replace($teshu[0][$i],$teshu[1][$i],$name);
}
for($i=0;$i<sizeof($teshu[2]);$i++){
    $name=str_replace($teshu[2][$i],'',$name);
}
if($name==""){
    // url暂不支持
    header("Location: ./error.php?error_code=5&url=".$jx);
    exit();
}
if(array_key_exists("gx", $_POST)|array_key_exists("gx", $_GET)){if(isset($_POST["gx"])){$gx = $_POST["gx"];}else{$gx = $_GET["gx"];}}
// 存放搜索记录到 cookie
$search = serialize(array($name,time()));
$expire=time()+60*60*24*30;
setcookie("search", $search, $expire);    // 存放搜索数据

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title><?php echo $name;?>·检索结果</title>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <link rel="bookmark" href="./favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/d.css" type="text/css" />
</head>
<body>
<div id="head">
    <div id="head1">
        <a href=".." _stat="video:poster_v">首页</a>
    </div>
    <div id="head2">
        <form action="./dx.php" method='POST' onsubmit="return checkform();">
            <p>关建字：<input id="ipt" type="text" name="wd" autofocus value="<?php echo $name;?>">
            <input type="submit" value="检索">
            <form action="./dx.php" method='POST' onsubmit="return checkform();">
            <input type="hidden" name="wd" autofocus value="<?php echo $name;?>">
            <input type="hidden" name="gx" value="1">
            <input type="submit" value="更新">
            </form>
            </p>
            <p>如果没有检索结果，请减少关键词</p>
        </form>
    </div>
</div>
    <script type="text/javascript" >
    function checkform(){
        if(document.getElementById('ipt').value.length==0){
            alert('输入不能为空！！！');
            document.getElementById('ipt').focus();
            return false;
        }
        else{return true}
    }
    </script>
<?php

$api=array('http://www.zdziyuan.com/inc/api_zuidam3u8.php','http://api.iokzy.com/inc/apickm3u8.php','https://www.kyzy.tv/api.php/kym3u8/vod/','http://cj.bajiecaiji.com/inc/bjm3u8.php','https://www.subo988.com/inc/maccms_subom3u8.php','http://cj.yongjiuzyw.com/inc/yjm3u8.php','http://cj.123ku2.com:12315/inc/123kum3u8.php','http://caiji.kuyun98.com/inc/ldg_kkm3u8.php','http://api.zuixinapi.com/inc/apixinm3u8.php','http://caiji.mb77.vip/inc/mbckm3u8.php','https://cj.heiyap.com/api.php/provide/vod/from/mam3u8/at/xml/','http://api.kbzyapi.com/inc/api_kakam3u8.php');//API方式 资源站API

$api1=array('最大API','okAPI','快影API','八戒API','速播API','永久API','123API','酷云API','最新API','秒播API','魔卡API','酷播API');//API方式 资源站API

$url=array("http://www.zuidazy5.com/index.php","http://www.okzyw.com/index.php","https://www.kuaiyingzy.com/index.php","http://www.bajiezy.cc/index.php","http://www.subo988.com/index.php","http://www.yongjiuzy1.com/index.php","http://www.123ku.com/index.php","http://www.kuyunzyw.tv/index.php","http://www.zuixinzy.net/index.php","https://www.mbo5.com/index.php","https://mokazy.com/index.php","http://www.kubozy.co/index.php");//爬虫方式 资源站的搜索页

$url1=array("最大爬取","ok爬取","快影爬取","八戒爬取","速播爬取","永久爬取","123爬取","酷云爬取","最新爬取","秒播爬取","魔卡爬取","酷播爬取");//爬虫方式 资源站的搜索页

$n = 0;

// 爬虫资源站页面
function playdetail($detailurl,$url1,$f){
    global $array,$n;
    $html = file_get_contents($detailurl);
    preg_match_all("/https?:\/\/.*\.jpe?g/",$html,$cover); // 封面 $cover[0][0]
    preg_match_all("/<h2>(.*)<\/h2>/",$html,$title); // 标题 $title[1][0]
    preg_match_all("/([^>]+)[$](https?.*\/index.m3u8)/",$html,$playurl);  // 播放地址
    preg_match_all("/上映：<span>(.*?)</",$html,$year);  // 上映时间 上映：<span>2016</span>
    preg_match_all("/类型：<span>(.*?)</",$html,$type);  // 类型：<span>恐怖片 <
    preg_match_all("/<div class=\"vodplayinfo\">(.*)\s*<\/div>/",$html,$des);  // ok 简介 des[1][0]
    if($des[1][0]="\n"){
        preg_match_all("/txt=\"(.*?)\"/",$html,$des);  // 最大 简介 des[1][0]
    }
    //preg_match_all("/[^>]+[$](https?.*mp4)/",$html,$download);  // 下载名称及地址
    for($i=0;$i<sizeof($playurl[2]);$i++){
        $array[$n]["tag"][$i]=$playurl[1][$i];  // 集数
        $array[$n]["url"][$i]=$playurl[2][$i];  // 播放地址
    }
    $array[$n]["cover"]=$cover[0][0];  // 封面
    $array[$n]["title"]=$title[1][0];  // 名称
    $array[$n]["year"]=$year[1][0];  // 上映时间
    $array[$n]["type"]=$type[1][0];  // 类型
    $array[$n]["des"]=$des[1][0];  // 简介
    $array[$n]["zy"]=$url1;  // 资源来源
    if($f){
        build($f);
    }
    $n++;
    
}

//API 获取视频id geturl视频信息
function getname($api,$api1,$f){
    global $name;
    $data = file_get_contents($api."?wd=".$name);
    $xml = simplexml_load_string($data);
    foreach($xml->list->video as $video){
        $id=(string)$video->id;
        geturl($id,$api,$api1,$f);
    }
}

function geturl($id,$api,$api1,$f){
    $data = file_get_contents($api."?ac=videolist&ids=".$id);
    $xml = simplexml_load_string($data);
    foreach($xml->list->video as $video){
        global $array,$n;
        $type=(string)$video->type; //类型
        $year=(string)$video->year; //上映时间
        $des=(string)$video->des; //简介
        $pic=(string)$video->pic; //封面
        $url=(string)$video->dl->dd;   //播放地址
        preg_match_all("/http?:\/\/[^#]*\/index.m3u8/",$url,$playurl);
        preg_match_all("/#?([^#]+)[$]/",$url,$tag);
        $title=(string)$video->name;
        for($i=0;$i<sizeof($playurl[0]);$i++){
            $array[$n]["tag"][$i]=$tag[1][$i];  // 集数
            $array[$n]["url"][$i]=$playurl[0][$i];  // 播放地址
            //$array[$n]["download"][$i]="暂无";
        }
        $array[$n]["title"]=$title;  // 名称
        $array[$n]["type"]=$type;  // 类型
        $array[$n]["year"]=$year;  // 上映时间
        $array[$n]["des"]=$des;  // 简介
        $array[$n]["cover"]=$pic;  // 封面
        $array[$n]["zy"]=$api1;  // 资源来源
        if($f){
            build($f);
        }
        $n++;
    }
}

function build($f){
    global $array,$n,$file,$name;
    $luanma=array("<",">","rgb","(17, 17, 17)","&nbsp","span","style","="," ","color",":","13px","font-family","Helvetica",",","Arial","sans-serif",";","font-size","\"","/","br"); //部分简介乱码
    for($i=0;$i<sizeof($luanma);$i++){
        $array[$n]["des"]=str_replace($luanma[$i],"",$array[$n]["des"]);
    }
    if(isset($array[$n]["title"])){
        print_r('<div id="playul"><div><a id="cover" href="./play.php?wd='.$name.'&id='.$n.'" target="_blank" title="'.$array[$n]["des"].'" class="figure result_figure" _stat="video:poster_v">');  // 封面
        print_r('<img class=\"figure_pic\" src="'.$array[$n]["cover"].'"/>');
        print_r("<span class=\"figure_caption\"><span class=\"figure_info\">".$name."</span></span>");
        print_r("<span class=\"fuzzy-logic-card\">".$array[$n]["zy"]."</span>");
        print_r("<span class=\"mark_x\"><span class=\"figure_info topleftright\" style=\"background:#00B3C5\">".$array[$n]["year"]."</span></span>");
        print_r("<span class=\"mark_v\"><span class=\"figure_info topleftright\" style=\"background:#FC4273\">".$array[$n]["type"]."</span></span>");
        print_r('</a></div></div>');
    }
    if($f){
        if(false!==fopen($file,'w+')){ 
            file_put_contents($file,serialize($array));//写入缓存 
        }
    }
}

function getarray($f){
    global $api,$api1,$url,$url1,$name;
    for($i=0;$i<sizeof($api);$i++){    // API 方式
        getname($api[$i],$api1[$i],$f);
    }
    for($i=0;$i<sizeof($url);$i++){   // 爬虫方式
        $html = file_get_contents($url[$i]."?m=vod-search&wd=".$name);
        preg_match_all("/\?m=vod-detail-id-.+.html/",$html,$detail);
        foreach($detail[0] as $x=>$x_value){
            playdetail($url[$i].$x_value,$url1[$i],$f);
        }
    }
}


$file="./data/".$name.".p";
preg_match_all("/\((.*?)\)/",$_SERVER['HTTP_USER_AGENT'],$llq);
$user = "域名:".@$_SERVER['SERVER_NAME']."\$ip:".@$_SERVER['REMOTE_ADDR']."\$".@$_SERVER['HTTP_CF_CONNECTING_IP']."\$用户:".@$_SERVER['USERDOMAIN'].@$_SERVER['USERNAME'].@$_SERVER['HTTP_CF_RAY']."\$浏览器:".$llq[1][0]."\$时间:".date("Y-m-d H:i:s",time())."\$检索:".$name."\n<br>";  //用户识别码
$log = fopen("./data/.log","a");
fwrite($log,$user);
fclose($log);
//读出缓存 
if(file_exists($file)){
    $handle=fopen($file,'r');// 存在 读取内容 只建立网页  只API 只爬取 
    $array=unserialize(fread($handle,filesize($file)));
    for($n=0;$n<sizeof($array);$n++){
        build(false);  // 只建立网页，不更新内容
    }
    date_default_timezone_set("Asia/Shanghai");
    $time=time()-filemtime($file);
    echo "<br><p>更新时间：".date("Y-m-d H:i:s",filemtime($file))."</p>";
    if($time>86400|$gx==1){    // 缓存文件太久才会更新  86400 24H 43200 12H
        $n=0;
        getarray(false);  // 获取数据（不建立网页）
        if(false!==fopen($file,'w+')){ 
            file_put_contents($file,serialize($array));//写入缓存 
        }
    }
    
}
else{//不存在 第一次  边API 边爬取 边建立网页 边存  因为完整太慢 每一组数据存一次   
    if(!isset($_COOKIE['count'])){
        setcookie('count',1,time()+15);
        getarray(true);  // 获取数据（并建立网页）
    } else if ($_COOKIE['count'] < 2){
        setcookie('count',$_COOKIE['count']+1,time()+15);
        getarray(true);  // 获取数据（并建立网页）
    }else{echo '新提交太频繁，15秒内只能提交两次，请等待15秒后在试。';}  // 防止恶意 浪费服务器资源
}

?>
</body>
</html>