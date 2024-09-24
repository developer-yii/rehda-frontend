<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MembershipActivated extends Mailable
{
    use Queueable, SerializesModels;

    public $fname;
    public $uname;
    public $pws;
    public $compname;
    public $fromEmail;
    public $fromName;

    /**
     * Create a new message instance.
     */
    public function __construct($fname, $uname, $pws, $compname, $fromEmail, $fromName)
    {
        $this->fname = $fname;
        $this->uname = $uname;
        $this->pws = $pws;
        $this->compname = $compname;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . config('constant.COMP_NAME2') . '] Congratulations! Your membership account is activated.',
            from: new Address($this->fromEmail, $this->fromName), // Dynamically set 'from' and 'from name'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.emails.membership_activated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
