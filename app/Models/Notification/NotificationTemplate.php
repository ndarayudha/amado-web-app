<?php

namespace App\Models\Notification;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'notification_templates';

    protected $fillable = [
        'title',
        'description',
        'topic',
        'image'
    ];


    /**
     * * Each Notification has one Topics
     */
    public function topic()
    {
        return $this->hasOne(NotificationTopic::class);
    }

    /**
     * * NotificationTemplate belongs to many Patient using Notification pivot
     */
    public function patients()
    {
        return $this->belongsToMany(Patient::class)->using(Notification::class)->withTimestamps();
    }
}
