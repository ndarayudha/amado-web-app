<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification\NotificationTemplate;

class PulseOximetryNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::create([
            'title' => 'Waktunya Monitoring',
            'description' => 'Saatnya melakukan monitoring kadar saturasi anda, lakukan dengan durasi 1 menit',
            'notification_topic_id' => ID_TOPIC_PULSE_MONITORING,
            'image' => ''
        ]);

        NotificationTemplate::create([
            'title' => 'Hasil Monitoring',
            'description' => 'Monitoring selesai silahkan lihat hasil dan solusi penanganan yang diberikan',
            'notification_topic_id' => ID_TOPIC_PULSE_RESULT,
            'image' => ''
        ]);
    }
}
