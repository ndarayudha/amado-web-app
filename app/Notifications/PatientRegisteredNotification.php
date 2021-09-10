<?php

namespace App\Notifications;

use App\Models\Patient\Patient;
use Illuminate\Notifications\Notification;

class PatientRegisteredNotification extends Notification
{

    public Patient $patient;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'database' ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'patient' => $this->patient
        ];
    }
}
