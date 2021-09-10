<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenangananMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('amado-ehealth@gmail.com')
            ->view('mail.isolasi-mandiri')
            ->with([
                'rekam_medis_id' => $this->data['rekam_medis_id'],
                'bpm' => $this->data['bpm'],
                'diagnosa' => $this->data['diagnosa'],
                'oksigen' => $this->data['oksigen'],
                'ruangan' => $this->data['ruangan'],
                'saran' => $this->data['saran'],
                'tanggal_masuk' => $this->data['tanggal_masuk'],
                'tanggal_keluar' => $this->data['tanggal_keluar'],
                'tindakan' => $this->data['tindakan'],
            ]);
    }
}
