<?php

/**
 * TravelViewHelper
 *
 * @author
 *
 * @version
 *
 */
namespace Travel\View\Helper;

use AceLibrary\View\Helper\AbstractViewHelper;

/**
 * View Helper
 */
class UrlFilter extends AbstractViewHelper
{

    public function __invoke($str, $lenght = 60)

    {
        $str = strtolower(str_replace(' ', '-', $str));
        $str = strtolower(str_replace('%20', '-', $str));

        if (preg_match('/[^a-zA-Z0-9\-\_\.]*/si', $str)) {
            $str = $this->translitIt($str);

            $str = preg_replace('/[^a-zA-Z0-9\-\_\.]*/', '', $str);
        }
        return $str;
        if (!preg_match('/[A-Za-z0-9]+/si', $str)) {
            $str = '';
        }
        if (strlen($str) > $lenght) {
            $str = substr($str, 0, $lenght);
        }

        $str = preg_replace('/\-+/si', '-', $str);

        $str = trim($str, '-');

        return $str;
    }

    public function translitIt($str)
    {
        $tr = array(
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g",
            "Д" => "d", "Е" => "e", "Ё" => "io", "Ж" => "j", "З" => "z", "И" => "i",
            "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
            "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch",
            "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "yi", "Ь" => "",
            "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "io", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($str, $tr);
    }
}