<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invno;
    public $fullname;
    public $filename;
    public $filePath;
    public $fromEmail;
    public $fromName;
    public $sub;
    public $auth;

    /**
     * Create a new message instance.
     */
    public function __construct($invno, $fullname, $filename, $filePath, $sub, $fromEmail, $fromName)
    {
        $this->invno = $invno;
        $this->fullname = $fullname;
        $this->filename = $filename;
        $this->filePath = $filePath;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        $this->sub = $sub;
        $this->auth = md5($invno) . sha1($invno) . md5(sha1($invno));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sub,
            from: new Address($this->fromEmail, $this->fromName), // Dynamically set 'from' and 'from name'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.emails.payment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attaching the invoice file
            Attachment::fromPath($this->filePath) // Assuming $filePath contains the full path to the file
                ->as($this->filename) // Name the file in the email
                ->withMime('application/pdf') // Set the MIME type of the file
        ];
    }
}
