<?php
/**
 * Created by PhpStorm.
 * User: georgy
 * Date: 01.03.19
 * Time: 19:15
 */

namespace App\Services;


class Validation
{

    public function validate($pass){

        if(iconv_strlen($pass) >= 12) $l = true; else $l = false; //Больше 12
        $a = preg_match('/[[:lower:]]/', $pass); // мал. буква
        $b = preg_match('/[[:upper:]]/', $pass); //Большая буква
        $c = preg_match('/\d/', $pass); //цифра
        $p = !preg_match('/(.)\1{2,}/', $pass); //нет трех повторов

        return $l&&$a&&$b&&$c&&$p;
    }

}