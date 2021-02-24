<?php
namespace App\Modules\Client\Classes;

class ClientStatusCode {
    public static $PENDING = 0;
    public static $CONFIRMED = 1;
    public static $DECLINED = 2;
    public static $ACTIVATED = 3;

    public static function returnCode($index){
        $codes = ['PENDING', 'CONFIRMED', 'DECLINED', 'ACTIVATED'];
        foreach ($codes as $key => $value) {
            if (static::$$value == $index) {
                return $value;
            }
        }
    }
}
