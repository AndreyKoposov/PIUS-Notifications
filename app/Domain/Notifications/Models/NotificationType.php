<?php

namespace App\Domain\Notifications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'notification_types';

    public function notifications() {
        return $this->hasMany(Notification::class, 'id', 'notification_type_id');
    }
}
