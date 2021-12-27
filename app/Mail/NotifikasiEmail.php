<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiEmail extends Mailable
{
    use Queueable, SerializesModels;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $peserta)
    {
        //
        $this->details = $details;
        $this->peserta = $peserta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pemberitahuan Jadwal Rapat')
            ->view('meeting.notifikasi-email')
            ->with(
                [
                    'judul' => $this->details['nama'],
                    'date' => $this->details['date'],
                    'time' => $this->details['time'],
                    'place' => $this->details['place'],
                    'description' => $this->details['description'],
                    'nama'  => $this->peserta['name']
                ]
            );
    }
}
