<?php

namespace App\Domain\Notifications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users_notifications';
    protected $guarded = [];
}
