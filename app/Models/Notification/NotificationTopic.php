<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTopic extends Model
{
    use HasFactory;

    protected $table = 'notification_topics';

    protected $fillable = [
        'topic'
    ];

    /**
     * * Notification Topic belongs to one notification template
     */
    public function notificationTemplate()
    {
        return $this->belongsTo(NotificationTemplate::class);
    }
}
