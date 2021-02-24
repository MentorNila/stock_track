<?php

namespace App\Traits;

use Illuminate\Notifications\RoutesNotifications;

trait Notification
{
    use HasDatabaseNotifications, RoutesNotifications;
}
