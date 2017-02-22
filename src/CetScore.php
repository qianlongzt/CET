<?php
namespace Qianlongzt\Cet;

class CetScore
{
    public static function getScore($name, $ticket, $source = 'chsi')
    {
        if($source == 1 || $source == 'chsi') {
            return self::getScoreFromChsi($ticket, $name);
        } else {
            return self::getScoreFrom99($ticket, $name);
        }
    }

    public static function cetInfo($ticket)
    {
        $pattern = '#^\d{6}(\d{2})(\d)(\d)(\d{3})(\d{2})#';
        if(!preg_match($pattern, $ticket, $match)) {
            return false;
        }

        $arr['examTime'] = '20'.$match[1].'年'.($match[2] == '1' ? '06': ($match[2] == '2'?'12':'')).'月';
        switch($match[3]){
                case '1':$type ='英语四级'; break;
                case '2':$type ='英语六级'; break;
                case '3':$type ='日语四级'; break;
                case '4':$type ='日语六级'; break;
                case '5':$type ='德语四级'; break;
                case '6':$type ='德语六级'; break;
                case '7':$type ='俄语四级'; break;
                case '8':$type ='俄语六级'; break;
                case '9':$type ='法语四级'; break;
                default: $type ='';break;
        }
        $arr['examType'] = $type;
        $arr['examRoom'] = $match[4];
        $arr['examSeat'] = $match[5];
        return $arr;
    }

    public static function getScoreFrom99($ticket, $name)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://cet.99sushe.com/getscore');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_REFERER, 'http://cet.99sushe.com/');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'id='.$ticket.'&name='.urlencode(iconv('utf-8','gbk',mb_substr($name,0,2))));
        $scoreString = curl_exec($curl);
        curl_close($curl);
        $content = iconv('gbk','utf-8', $scoreString);
        $scores = explode(',',$content);

        $arr = array();
        if(count($scores) === 11){
            $info = self::cetInfo($ticket);
            $arr['status'] = true;
            $arr['errType'] =  0;
            $arr['name'] =  $scores[7];
            $arr['school'] = $scores[6];
            $arr['type'] = $info['examType'];
            $arr['ticket'] = $scores[1];
            $arr['examTime'] = $info['examTime'];
            $arr['score'] = (int) $scores[5];
            $arr['listening'] = (int) $scores[2];
            $arr['reading'] = (int) $scores[3];
            $arr['writing'] = (int) $scores[4];
            $arr['hearingLoss'] = (bool) $scores[8];
            $arr['spokenTestid'] = $scores[9];
            $arr['spokenGrade'] = $scores[10];
        } else if(count($scores) === 1 ) {
            $arr['status'] = false;
            $arr['errMsg'] = '未知错误';
            if($scores[0] === '4') {
                $arr['errType'] = 1;
            } else {
                $arr['errType'] = 2;
            }
        }
        $arr['source'] = '99sushe';
        return $arr;
    }

    public static function getScoreFromChsi($ticket, $name)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url = 'http://www.chsi.com.cn/cet/query?zkzh='.$ticket.'&xm='.mb_substr($name, 0, 3));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.chsi.com.cn/cet/');
        $scoreHtml = curl_exec($curl);
        curl_close($curl);
        preg_match('#请确认你输入的准考证号及姓名无误#', $scoreHtml, $match);
        if(count($match) == 1) {
            return array(
                'status' => false,
                'errType' => 1,
                'errMsg'  => '错误的准考证或姓名',
                'source' => 'chsi'
            );
        }
        preg_match('#<table[^>]*class="cetTable">(.+?)</table>#is', $scoreHtml, $match);
        if(count($match) < 1) {
            return array(
                'status' => false,
                'errType' => 2,
                'errMsg' => '匹配错误',
                'source' => 'chsi'
            );
        }
        $scoreString =  preg_replace('#<[^>]*>#','',$match[1]);
        $scoreString = preg_replace('#\s#','', $scoreString);
        $scoreString = preg_replace('#&nbsp;#','', $scoreString);
        $scoreString = preg_replace('#：#','', $scoreString);
        $pattern = '#姓名(\S+)学校(\S+)考试级别(\S+)笔试成绩准考证号(\S+)总分(\S+)听力(\S+)阅读(\S+)写作和翻译(\S+)口试成绩准考证号(\S+)等级(\S+)#';
        preg_match($pattern, $scoreString, $match);
        if(count($match) >= 10) {
            $info = self::cetInfo($ticket);
            $arr['status'] = true;
            $arr['errType'] = 0;
            $arr['name'] = $match[1];
            $arr['school'] = $match[2];
            $arr['type'] = $match[3];
            $arr['examTime'] = $info['examTime'];
            $arr['ticket'] = $match[4];
            $arr['score'] =(int) $match[5];
            $arr['listening'] =(int) $match[6];
            $arr['reading'] = (int) $match[7];
            $arr['writing'] = (int) $match[8];
            $arr['spokenTestid'] = $match[9];
            $arr['spokenGrade'] = $match[10];
        } else {
            $arr['status'] = false;
            $arr['errType'] = 'ohter';
            $arr['errMsg'] = '未知错误';
        }
        $arr['source'] = 'chsi';
        return $arr;
    }
}

