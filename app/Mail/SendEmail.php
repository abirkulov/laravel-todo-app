<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailFrom;
    public $subject;
    public $text;
    public $rawData;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailFrom, $subject, $text, $rawData, $fileName)
    {
        $this->subject = $subject;
        $this->text = $text;
        $this->rawData = base64_decode($rawData);
        $this->fileName = $fileName;
        $this->emailFrom = $emailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from($this->emailFrom)
        //             ->view('emails.mail-content')
        //             ->attach($this->file->getRealPath(), [
        //                 'as' => $this->file->getClientOriginalName(),
        //                 'mime' => $this->file->getClientMimeType()
        //             ]);
        
        /**
         * Sending an email with "raw data" attachment
         */
        return $this->from($this->emailFrom)
            ->view('emails.mail-content');
    }
}
