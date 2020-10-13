<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmemail extends Mailable
{
    use Queueable, SerializesModels;
    public $messageData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageData)
    {
        $this->messageData=$messageData;
        //$email=$this->messageData['email'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('Activate Your Account on Gov-Ecom')->view('emails.confirmEmail');
    }
}
