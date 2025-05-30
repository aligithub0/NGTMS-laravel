<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $url; // Add this if you want to use buttons

    public function __construct($subject, $content, $url = null)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->markdown('emails.generic') // Changed from view() to markdown()
            ->with([
                'subject' => $this->subject,
                'content' => $this->content,
                'url' => $this->url
            ]);
    }
}