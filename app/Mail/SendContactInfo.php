<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactInfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $valid_email;
    public function __construct($valid_email)
    {
        //
        $this->valid_email = $valid_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $from_email = $this->valid_email->email;
         return $this->view('MailView.SendContactInfo')->subject('New Enquiry Fun Games Asiaa');
        //return $this->from($from_email)->view('MailView.SendContactInfo')->subject('New Enquiry Fun Games Asiaa');
        // return $this->view('Mail_View.valid_email')->subject('OTP Validation');
    }
}
