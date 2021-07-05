<?php

namespace Database\Seeders;

use App\Models\Notification\NotificationTopic;
use Illuminate\Database\Seeder;

class NotificationTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTopic::create([
            'topic' => 'pulse_monitoring'
        ]);

        NotificationTopic::create([
            'topic' => 'pulse_result'
        ]);
    }
}
