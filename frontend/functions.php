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
    public function diff_result($date,$param = 'long'){
        $diff = time()-strtotime($date);
        $year = 31536000;
        $month = 2592000;
        $answer = '';
        $rest = 0;

        if($diff/($year*10) > 1 and $diff-floor($diff/($year*10))*$year*10 > $year) //10 лет и больше
        {
            $rest = $diff-floor($diff/($year*10))*$year*10;
        } else {
            $rest = $diff;
        }

        if ($rest >= $year*5) //5 лет и больше
        {
            $answer = floor($diff/$year).' лет';

            if($param === 'long'){
                $diff_month = $diff - $year*floor($diff/$year);
                if($diff_month>= $month){
                    $answer .= ' и ' .floor($diff_month/$month).' мес.';
                }
            }
        }
        elseif ($rest >= $year*2)
        {
            $answer = floor($diff/$year).' годa';

            if($param === 'long'){
                $diff_month = $diff - $year*floor($diff/$year);
                if($diff_month>= $month){
                    $answer .= ' и ' .floor($diff_month/$month).' мес.';
                }
            }
        }
        elseif ($rest >= $year)
        {
            $answer = floor($diff/$year).' год';

            if($param === 'long'){
                if(($diff-$year)>= $month){
                    $answer .= ' и ' .floor(($diff-$year)/$month).' мес.';
                }
            }
        }
        elseif ($diff >= $month)
        {
            $answer = floor($diff/$month).' мес.';
        }
        elseif ($diff >= 86400)
        {
            $answer = floor($diff/86400).' дней';
        }
        elseif ($diff >= 16200)
        {
            $answer = round($diff/3600).' часов';
        }
        elseif ($diff >= 5400)
        {
            $answer = round($diff/3600).' часа';
        }
        elseif ($diff >= 3600)
        {
            $answer = 'час назад';
        }
        elseif ($diff >= 270)
        {
            $answer = round($diff/60).' минут';
        }
        elseif ($diff >= 90)
        {
            $answer = round($diff/60).' минуты';
        }
        elseif ($diff >= 60)
        {
            $answer = 'минуту';
        }
        else
        {
            $answer = 'только что';
        }

        if($param === 'long' and $diff >= 60)
        {
            $answer .= ' назад';
        }
        return $answer;
    }

}
