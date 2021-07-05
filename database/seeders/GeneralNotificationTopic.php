<?php

namespace Database\Seeders;

use App\Models\Notification\NotificationTopic;
use Illuminate\Database\Seeder;

class GeneralNotificationTopic extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTopic::create([
            'topic' => 'general_new_user'
        ]);
    }
}
