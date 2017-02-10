<?php
namespace Qianlongzt\Cet;

class CetSchoolCode
{
    protected $codes;

    public function __construct() 
    {
        $this->codes = json_decode(file_get_contents(__DIR__ . '/cetSchoolCode.json'), true);
    }

    public function getName($code)
    {
        $code = (string) $code;
        $results = [];
        foreach($this->codes as $v) {
            if($v['code'] === $code) {
                $results[] = $v['name'];
            } else if( (int)$v['code'] > (int) $code) {
                break;
            }
        }
        return $results;
    }
}

