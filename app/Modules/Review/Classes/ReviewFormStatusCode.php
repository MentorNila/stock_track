<?php
namespace App\Modules\Review\Classes;

class ReviewFormStatusCode {
    public static $FILL_OUT_THE_FORM = 0;
    public static $SIGN_OFF_THE_FORM = 1;
    public static $AWAITING_SUBMISSION = 2;

    public static function returnCode($index){
        $codes = ['FILL_OUT_THE_FORM', 'SIGN_OFF_THE_FORM', 'AWAITING_SUBMISSION'];
        foreach ($codes as $key => $value) {
            if (static::$$value == $index) {
                return $value;
            }
        }
    }
}
