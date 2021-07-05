<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Notification extends Pivot
{
    use HasFactory;

    protected $table = 'notifications';
}
