<?php

namespace frontend\src;

use Yii;
use yii\helpers\Html;

class CustomFormatter extends \yii\i18n\Formatter
{
    /**
     * Formats the value as a hyperlink.
     * @param mixed $value the value to be formatted.
     * @param array $options the tag options in terms of name-value pairs. See [[Html::a()]].
     * @return string the formatted result.
     */
    public static function asPhone($value, $options = [])
    {
        if ($value === null) {
            return null;
        }
        $url = $value;
        if (is_numeric($url)) {
            $url = 'tel:' . $url;
            $ph = str_split($value);
            if($ph[0] !== 8 or count($ph)<11) {
                array_unshift($ph,8);
            }
            $phone = "$ph[0] ($ph[1]$ph[2]$ph[3]) $ph[4]$ph[5]$ph[6] $ph[7]$ph[8] $ph[9]$ph[10]";
        }
        return Html::a(Html::encode($phone), $url, $options);
    }

    /**
     * Formats the value as a mailto link.
     * @param string $value the value to be formatted.
     * @param array $options the tag options in terms of name-value pairs. See [[Html::mailto()]].
     * @return string the formatted result.
     */
    public static function asSkype($value, $options = [])
    {
        if ($value === null) {
            return null;
        }
        $url = $value;
        $url = 'skype:' . $url;

        return Html::a(Html::encode($value), $url, $options);
    }

    /**
     * Formats the value as an image tag.
     * @param mixed $value the value to be formatted.
     * @param array $img_options the tag options in terms of name-value pairs. See [[Html::img()]].
     * @param array $a_options the tag options in terms of name-value pairs. See [[Html::a()]].
     * @return string the formatted result.
     */
    public static function asPhoto($value, $img_options = [], $a_options =[])
    {
        if ($value === null) {
            return null;
        }
        $url = '/user_files/'.$value;

        return Html::a(Html::img($url, $img_options), $url, $a_options);
    }
}
