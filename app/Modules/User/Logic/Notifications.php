<?php namespace App\Modules\User\Logic;

use Carbon\Carbon;

class Notifications
{
    protected $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    public function markNotificationAsRead($notificationId){
        if (is_null($notificationId)){
            $this->user->unreadNotifications()->update(['read_at' => Carbon::now()]);
        } else {
            $this->user->unreadNotifications()->where('id', $notificationId)->update(['read_at' => Carbon::now()]);
        }
    }

}
