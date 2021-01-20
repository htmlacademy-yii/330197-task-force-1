<?php
declare(strict_types=1);
namespace frontend;
use Yii;


class Functions {
    /**
    * Функция показывает разницу во времени. Показывает сколько прошло минут,часов, дней, месяцев, лет.
    * @param $data string дата, которую мы хотим представить в нужном формате
    * @param $param string если аргумент отличается от 'long' результат работы функции отрезает слово "назад" вконце формата переданной даты
    * @param $diff int внутренняя переменная функции, содержит разницу во времени (количество секунд) между текущим временем и временем, переданным в переменной $date
    */
    const MINUTE = 60;
    const HOUR = self::MINUTE * 60;
    const DAY = self::HOUR * 24;
    const WEEK = self::DAY * 7;
    const MONTH = self::DAY * 30;
    const YEAR = self::DAY * 365;

    public function diff_result(string $date, string $param = 'long'): string
    {
        $ending = "назад";
        if($param !== 'long'){
           $ending = "";
        }

        $diff = (int)(time()-strtotime($date));

        $years = (int)($diff/self::YEAR);
        if($years > 0){
            return \Yii::t('app',"{n, plural, one{# год} few{# годa} many{# лет} other{# лет}} $ending", ['n' => $years]);
        }

        $months = (int)($diff/self::MONTH);
        if($months > 0){
            return \Yii::t('app',"{n, plural, one{# месяц} few{# месяца} many{# месяцев} other{# месяцев}} $ending", ['n' => $months]);
        }

        $days = (int)($diff/self::DAY);
        if($days > 0){
            return \Yii::t('app',"{n, plural, one{# день} few{# дня} many{# дней} other{# дней}} $ending", ['n' => $days]);
        }

        $hours = (int)($diff/self::HOUR);
        if($hours > 0){
            return \Yii::t('app',"{n, plural, one{# час} few{# часа} many{# часов} other{# часов}} $ending", ['n' => $hours]);
        }

        $minutes = (int)($diff/self::MINUTE);
        if($minutes > 0){
            return \Yii::t('app',"{n, plural, one{# минуту} few{# минуты} many{# минут} other{# минут}} $ending", ['n' => $minutes]);
        }

        return "только что";
    }

}
