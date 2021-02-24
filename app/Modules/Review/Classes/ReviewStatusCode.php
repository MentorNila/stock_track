<?php
namespace App\Modules\Review\Classes;

class ReviewStatusCode {
    public static $ACTIVE = 0;
    public static $SCHEDULED = 1;
    public static $COMPLETED = 2;

    public static function returnCode($index){
        $codes = ['ACTIVE', 'SCHEDULED', 'COMPLETED'];
        foreach ($codes as $key => $value) {
            if (static::$$value == $index) {
                return $value;
            }
        }
    }
}
