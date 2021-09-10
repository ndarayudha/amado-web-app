<?php

namespace App\Events;

use App\Models\Patient\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientRegisteredEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Patient $patient;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('patient-registered-channel');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->patient->id,
            'name' => $this->patient->name,
            'email' => $this->patient->email,
            'created_at' => $this->patient->created_at,
        ];
    }

    public function broadcastAs()
    {
        return 'PatientRegisteredEvent';
    }
}
