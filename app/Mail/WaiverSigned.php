<?php

namespace App\Mail;

use App\Waiver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WaiverSigned extends Mailable
{
    use Queueable, SerializesModels;

    public $waiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Waiver $waiver)
    {
        $this->waiver = $waiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.waiver-signed')
            ->from('board@midsouthmakers.org')
            ->subject('Your Midsouth Makers Signed Waiver')
            ->attach(storage_path().'/waivers/'.$this->waiver->id.'.pdf', [
                'as' => 'signed-waiver.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
