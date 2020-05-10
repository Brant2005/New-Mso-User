<?php
include "config.cfg";

function getParam($key,$default=""){
    return trim($key && is_string($key) ? (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default)) : $default);
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function pwd8(){
    $chars1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $chars2 = "abcdefghijklmnopqrstuvwxyz";
    $hash = $chars1[mt_rand(0,25)];
    for($i = 0;$i < 3;$i++) $hash .= $chars2[mt_rand(0,25)];
    $hash .= mt_rand(1000,9999);
    return $hash;
}

function check_key($key){
    $key_type = "";
    $key_base = json_decode(file_get_contents("../key.json"),true);
    if(array_key_exists($key,$key_base)) $key_type = "ok";
    if($key_type){
        return array("Key"=>$key,"License"=>$key_type,"Units"=>$key_base[$key]);
    }else{
        return array("Key"=>$key,"License"=>"","Units"=>"");  
    }
}

function reduce_key($key){
    $key_base = json_decode(file_get_contents("../key.json"),true);
    $after_num = $key_base[$key] - 1;
    $after_num = $after_num < 0 ? 0 : $after_num;
    $key_base[$key] = $after_num;
    file_put_contents("../key.json",json_encode($key_base));
    return;
}