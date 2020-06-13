<?php
namespace frontend;
use Yii;

class Functions {
    /**
    * Функция показывает разницу во времени. Показывает сколько прошло минут,часов, дней, месяцев, лет.
    * @param $data string дата, которую мы хотим представить в нужном формате
    * @param $diff int внутренняя переменная функции, содержит разницу во времени (количество секунд) между текущим временем и временем, переданным в переменной $date
    *
    * @return $answer переменная содержит нужный нам формат времени
    */
    public function diff_result($date){
        $diff = time()-strtotime($date);
        $answer = '';
        // if ($diff >= 86400) {
        //     $answer = date('d.m.y', strtotime($date)).' в '.date('H:i', strtotime($date));
        // }
        if ($diff >= 157680000) {
            $answer = floor($diff/31536000).' лет';

            $diff_month = $diff - 31536000*floor($diff/31536000);
            if($diff_month>= 2592000){
                $answer .= ' и ' .floor($diff_month/2592000).' мес.';
            } 
            $answer .= ' назад';
        }
        elseif ($diff >= 63072000) {
            $answer = floor($diff/31536000).' годa';

            $diff_month = $diff - 31536000*floor($diff/31536000);
            if($diff_month>= 2592000){
                $answer .= ' и ' .floor($diff_month/2592000).' мес.';
            } 
            $answer .= ' назад';
        }
        elseif ($diff >= 31536000) {
            $answer = floor($diff/31536000).' год';

            if(($diff-31536000)>= 2592000){
                $answer .= ' и ' .floor(($diff-31536000)/2592000).' мес.';
            } 
            $answer .= ' назад';
        }
        elseif ($diff >= 2592000) {
            $answer = floor($diff/2592000).' мес. назад';
        }
        elseif ($diff >= 86400) {
            $answer = floor($diff/86400).' дней назад';
        }
        elseif ($diff >= 16200) {
            $answer = round($diff/3600).' часов назад';
        }
        elseif ($diff >= 5400) {
            $answer = round($diff/3600).' часа назад';
        }
        elseif ($diff >= 3600) {
            $answer = 'час назад';
        }
        elseif ($diff >= 270) {
            $answer = round($diff/60).' минут назад';
        }
        elseif ($diff >= 90) {
            $answer = round($diff/60).' минуты назад';
        }
        elseif ($diff >= 60) {
            $answer = 'минуту назад';
        }
        else{
            $answer = 'только что';
        }
        return $answer;
    }

}