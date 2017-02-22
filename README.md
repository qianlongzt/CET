# CET

简单大学英语四六级库

## 开发其他语言版本

参考 [开发文档](dev-docs.md)

## 安装

通过 Composer 进行安装

``` bash
composer require qianlongzt/cet
```


## 使用 CetScore

``` php
<?php
require_once __DIR__ .'/vendor/autoload.php';

$ticket = '1234567891012345';
$name = '张三';
$source = '99sushe'; # chsi (学信网), 99sushe(99宿舍)
$cetScore = Qianlongzt\Cet\CetScore::getScore($name, $ticket, $source);
var_dump($cetScore);
```

输出像这样子

```
array(15) {
  ["status"]=>
  bool(true)    # 是否获取成功
  ["errType"]=>
  int(0)        # 错误代码
  ["errMsg"] =>
  "ok"          # 错误说明，为 0 时 不出现这个 key
  ["name"]=>
  string(6) "张三"
  ["school"]=>
  string(18) "xxx大学"
  ["type"]=>
  string(12) "英语四级"
  ["ticket"]=>
  string(15) "330000162100000" # 准考证号
  ["examTime"]=>
  string(12) "2016年12月"
  ["score"]=>
  int(471)                      # 总分
  ["listening"]=>               #听力
  int(166)
  ["reading"]=>                 # 阅读
  int(168)
  ["writing"]=>                 # 写作和翻译
  int(137)
  ["hearingLoss"]=>             # 听力残疾 只有来源是 99sushe 才有
  bool(false)
  ["spokenTestid"]=>            # 口语准考证号
  string(15) "F12345678901234"
  ["spokenGrade"]=>             # 口语等级
  string(3) "C+"
  ["source"]=>
  string(7) "99sushe"
}

``` 

## 使用 查学校名称

___有些学校可能一个编号对应于有多个名字___

``` php
<?php
require_once __DIR__ .'/vendor/autoload.php';

$code = new Qianlongzt\Cet\CetSchoolCode();
var_dump($code->getName('3303070'));
```
sample output like this
```
array(1) {
  [0]=>
    string(24) "杭州电子科技大学"
}

``` 
## 版权

The MIT License. Please see [License File](LICENSE.md) for more information.
