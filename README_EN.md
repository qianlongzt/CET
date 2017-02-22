# CET
a simple CET library. 简单大学英语四六级库

## Instal

Via Composer

``` bash
composer require qianlongzt/cet
```


## Usage CetScore

``` php
<?php
require_once __DIR__ .'/vendor/autoload.php';

$ticket = '1234567891012345';
$name = '张三';
$source = '99sushe'; # chsi (学信网), 99sushe(99宿舍)
$cetScore = Qianlongzt\Cet\CetScore::getScore($name, $ticket, $source);
var_dump($cetScore);
```

sample output like this

```
array(15) {
  ["status"]=>
  bool(true)
  ["errType"]=>
  int(0)
  ["name"]=>
  string(6) "张三"
  ["school"]=>
  string(18) "xxx大学"
  ["type"]=>
  string(12) "英语四级"
  ["ticket"]=>
  string(15) "330000162100000"
  ["examTime"]=>
  string(12) "2016年12月"
  ["score"]=>
  int(471)
  ["listening"]=>
  int(166)
  ["reading"]=>
  int(168)
  ["writing"]=>
  int(137)
  ["hearingLoss"]=>
  bool(false)
  ["spokenTestid"]=>
  string(15) "F12345678901234"
  ["spokenGrade"]=>
  string(3) "C+"
  ["source"]=>
  string(7) "99sushe"
}
``` 

## Usage CetSchoolCode

___important some code has many names in some cases___

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
## License

The MIT License. Please see [License File](LICENSE.md) for more information.
