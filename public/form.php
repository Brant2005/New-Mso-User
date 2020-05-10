<?php
include "../functions.php";

$key = $key2 = $domain_list = $name = $user = $email = $domain = $keyErr = $nameErr = $userErr = $emailErr = $domainErr = NULL;

if($_SERVER["REQUEST_METHOD"] != "POST"){ ?>
<!DOCTYPE HTML>
<!--
     ____ _  __ __  __ __ __ ____
    /  _// |/ // / / // //_// __ \
   _/ / /    // /_/ // ,<  / /_/ /
  /___//_/|_/ \____//_/|_| \____/

-->
<html lang="zh-CN" data-form="<?php echo $LOCALURL."/form.php"; ?>">
    <head>
        <meta charset="UTF-8">
        <link href="<?php echo $RESURL; ?>/static/css/form.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="container"><?php
        $key2 = test_input(getParam("key"));
        if($key2 != NULL){
            $check = check_key($key2);
            if(!$keyErr){
                if(!$check["License"]){
                    $keyErr = "兑换码无效";
                }elseif($check["Units"] == 0){
                    $keyErr = "兑换码已达到使用上限";
                }else{
                    $domain_list = $domains_365;
                }
            }
            if($domain_list) show_form2("","","","",$domain_list,"","","",$check); else show_form1($key2,$keyErr);
        }else show_form1("",""); ?>
        </div>
        <script src="<?php echo $RESURL; ?>/static/js/jquery.min.js"></script>
        <script src="<?php echo $RESURL; ?>/static/js/clipboard.js"></script>
        <script src="<?php echo $RESURL; ?>/static/js/form.min.js"></script>
    </body>
</html><?php
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["key"])){
        $keyErr = "兑换码是必需的";
    }else{
        $key = test_input($_POST["key"]);
        $check = check_key($key);
        if(!$keyErr){
            if(!$check["License"]){
                $keyErr = "兑换码无效";
            }elseif($check["Units"] == 0){
                $keyErr = "兑换码已达到使用上限";
            }
        }
    }
    if($keyErr){
        show_form1($key,$keyErr);
        exit;
    }

    if(empty($_POST["name"])){
        $nameErr = "显示名称是必需的";
    }else{
        $name = test_input($_POST["name"]);
    }

    if(empty($_POST["user"])){
        $userErr = "用户名是必需的 ";
    }else{
        $user = test_input($_POST["user"]);
        if(!preg_match("/^[a-zA-Z0-9._-]{3,16}$/",$user)) $userErr = "用户名只能由3位以上数字,字母,下划线和点构成 ";
    }

    if(empty($_POST["email"])){
        $emailErr = "邮箱是必需的";
    }else{
        $email = test_input($_POST["email"]);
        if(!preg_match("/^[a-zA-Z0-9._-]{1,}@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/",$email)) $emailErr = "邮箱格式不正确";
    }

    if(empty($_POST["domain"])){
        $domainErr = "非法域名";
    }else{
        $domain = test_input($_POST["domain"]);
        $domain_list = $domains_365;
        if(!in_array($domain,$domain_list)) $domainErr = "非法域名";
    }

    if(($nameErr || $emailErr || $userErr || $domainErr) == 0 && ($name && $user && $domain) == 1){
        $user .= "@".$domain;
        $tempwd = pwd8();
        $result = Shell_Exec ('powershell.exe -executionpolicy bypass -NoProfile -File "../create.ps1" -a "'.$acc_365.'" -b "'.$pwd_365.'" -c "'.$sku_365.'" -d "'.$name.'" -u "'.$user.'" -p "'.$tempwd.'"');
        if(strstr($result,"Fin")){ ?>
            <div class="finish">操作成功完成</div>
            <textarea id="result" name="result" readonly="true"><?php echo "用户名：".$user."\n临时密码：".$tempwd; ?></textarea>
            <span class="count">兑换码剩余计数：<strong><?php echo $check["Units"] - 1; ?></strong></span>
            <button class="button copy" type="button" name="copy" data-clipboard-target="#result">复制</button><?php
            reduce_key($check["Key"]);
            $file = "../log.json";
            $logjson = json_decode(file_get_contents($file),true);
            $logjson[] = array("time"=>date("Y-m-d H:i:s"),"key"=>$check["Key"],"mail"=>$email,"name"=>$name,"user"=>$user,"tempwd"=>$tempwd);
            file_put_contents($file,json_encode($logjson));
        }elseif(strstr($result,"Auth")){
            echo '<div class="finish2">操作失败</div><span>身份验证失败，请邮件联系 '.$Admin_Email.'。</span>';
        }elseif(strstr($result,"Unknown")){
            echo '<div class="finish2">操作失败</div><span>无法识别订阅，请邮件联系 '.$Admin_Email.'。</span>';
        }else echo '<div class="finish2">操作失败</div><span>账号创建失败，请更换用户名再试。若问题仍存在，请邮件联系 '.$Admin_Email.'。</span>';
    }else show_form2($name,$nameErr,$user,$userErr,$domain_list,$domainErr,$email,$emailErr,$check);
}

function show_form1($key,$keyErr){ ?>
        <div class="notice">请在下方输入您的兑换码。如果您没有兑换码，请咨询您的服务提供商。</div>
        <form id="form1">
            <div class="key">
                兑换码：<input id="key" autocomplete="off" type="text" name="key" value="<?php echo $key; ?>">
                <span class="error">*</span>
            </div>
            <div class="error keyerr"> <?php echo $keyErr; ?></div>
            <button class="button sub1" type="button" name="submit">提交</button>
        </form><?php
}

function show_form2($name,$nameErr,$user,$userErr,$domain_list,$domainErr,$email,$emailErr,$check){ ?>
        <div id="loading" style="display:none"><p>提交中，请稍候...</p></div>
        <form id="form2">
            <div class="name">
                显示名称：<input autocomplete="off" type="text" name="name" value="<?php echo $name; ?>">
                <span class="error">*</span>
            </div>
            <div class="error error2"><?php echo $nameErr; ?></div>
            <div class="user">
                用户名：<input autocomplete="off" type="text" name="user" value="<?php echo $user; ?>">@
                <select name="domain"><?php
                    foreach ($domain_list as $domain) echo '<option title="'.$domain.'" value="'.$domain.'">'.$domain.'</option>'; ?>
                </select>
                <span class="error">*</span>
            </div>
            <div class="error error2"><?php echo $userErr; echo $domainErr; ?></div>
            <div class="email">
                电子邮箱：<input type="text" name="email" value="<?php echo $email; ?>">
                <span class="error">*</span>
            </div>
            <div class="error error2"><?php echo $emailErr; ?></div>
            <div class="key">
                兑换码：<input id="key2" type="text" name="key" value="<?php echo $check["Key"]; ?>">
            </div>
            <div class="error info">剩余计数：<strong><?php echo $check["Units"]; ?></strong></div>
            <button class="button sub2" type="button" name="submit">提交</button>
        </form><?php
}