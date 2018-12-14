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
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailFrom, $subject, $text, $file)
    {
        $this->subject = $subject;
        $this->text = $text;
        $this->file = $file;
        $this->emailFrom = $emailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailFrom)
                    ->view('emails.mail-content')
                    ->attach($this->file->getRealPath(), [
                        'as' => $this->file->getClientOriginalName(),
                        'mime' => $this->file->getClientMimeType()
                    ]);
    }
}
