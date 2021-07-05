<?php

namespace App\Jobs;

use App\Outbound\Firebase\Implement\PatientCloudMessagingOutbound;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $patientId;
    protected int $notificationIDThatWillBeSend;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $patientId, $notficationID)
    {
        $this->patientId = $patientId;
        $this->notificationIDThatWillBeSend = $notficationID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PatientCloudMessagingOutbound $outbound)
    {
        $outbound->sendApiTokenNotification($this->patientId, $this->notificationIDThatWillBeSend);
    }
}
