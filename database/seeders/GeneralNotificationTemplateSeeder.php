<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification\NotificationTemplate;

class GeneralNotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::create([
            'title' => 'Selamat Datang',
            'description' => 'Selamat datang di Amado E-Heath, semoga harimu menyenangkan :)',
            'notification_topic_id' => ID_GENERAL_NEW_USER,
            'image' => ''
        ]);
    }
}
