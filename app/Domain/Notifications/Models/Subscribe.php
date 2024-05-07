<?php

namespace App\Domain\Notifications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $table = 'subscribes';
    protected $guarded = [];

    public function type() {
        return $this->belongsTo(NotificationType::class, 'notification_type_id', 'id');
    }
}
