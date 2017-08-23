<?php

$name = "张三";//姓名
$id = "123456123456781234";//身份证
$level = "1";//考试等级 四级1，六级2


$arr = array (
    "ks_xm" => $name,
    "ks_sfz" => $id,
    "jb" => $level
);

$query = "action=&params=" . urlencode(json_encode($arr));

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify ");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 3);
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
$res =  curl_exec($curl);
echo $res;
$res = json_decode($res);
