<?php
namespace App\Modules\Register\Classes;

class ClientRequestStatusCode {
    public static $PENDING = 0;
    public static $APPROVED = 1;
    public static $DECLINED = 2;

    public static function returnCode($index){
        $codes = ['Pending', 'Approved', 'Declined'];
        foreach ($codes as $key => $value) {
            if (static::$$value == $index) {
                return $value;
            }
        }
    }

}
