<?php
declare(strict_types=1);
namespace frontend\src;
use Yii;


class Functions {
    /**
    * Функция возвращает обрезанную строку до первого пробела не больше указанного числа символов.
    * @param $text string строка, которую необходимо обрезать
    * @param $chr_limit int максимальная длина строки, которую может вернуть функция
    * @param $length int внутренняя переменная функции, содержит фактическое значение длины строки до первого пробела, которое не превышает заданное значение параметра $chr_limit
    */
    public static function cut_string(string $text, int $chr_limit): string
    {
        $length = (strlen($text) <= $chr_limit) ? strlen($text) : strpos($text,' ',$chr_limit-10);
        return substr($text, 0, $length);
    }
}
