<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

/**
 * Custom DatabaseNotification model that uses the 'laravel_notifications' table
 * instead of the default 'notifications' table, which is already taken by the
 * app's custom notifications system (study reminders, etc.).
 */
class LaravelNotification extends DatabaseNotification
{
    protected $table = 'laravel_notifications';
}
