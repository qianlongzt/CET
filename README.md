# CET
a simple CET library. 简单大学英语四六级库

## Instal

Via Composer

``` bash
composer require qianlongzt/cet
```
## Usage

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
array(12) {
  ["status"]=>
    bool(true) # it's false mean can't the score right now.
  ["errType"]=>
    int(0)  # 0 mean no problem, 1 mean wrong ticket or name, 2 mean other's problem
  ["name"]=>
    string(6) "张三" 
  ["school"]=>
    string(24) "xxx大学"
  ["type"]=>
    string(12) "英语四级" # the exam type of cet
  ["ticket"]=>
    string(15) "123456789012345"
  ["examTime"]=>
    string(12) "2016年06月"
  ["score"]=>
    int(425) # total score
  ["listening"]=>
    int(175) 
  ["reading"]=>
    int(125)
  ["writing"]=>
    int(125)
  ["source"]=>
    string(7) "99sushe"
}


## License

The MIT License. Please see [License File](LICENSE.md) for more information.
