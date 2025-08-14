<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $subject;
    public $data;
    public $attachmentsFiles;

    /**
     * Create a new message instance.
     */
    public function __construct($msg, $subject, $data = [], $attachmentsFiles = [])
    {
        $this->msg = $msg;
        $this->subject = $subject;
        $this->data = $data;
        $this->attachmentsFiles = $attachmentsFiles;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            from: config('mail.from.address', 'noreply@example.com'),
            replyTo: config('mail.from.address', 'noreply@example.com')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.test-mail',
            with: [
                'subject' => $this->subject,
                'msg' => $this->msg,
                'data' => $this->data
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (isset($this->attachmentsFiles) && is_array($this->attachmentsFiles)) {
            foreach ($this->attachmentsFiles as $file) {
                if (isset($file['path']) && isset($file['original_name'])) {
                    $attachments[] = Attachment::fromStorageDisk('public', $file['path'])
                        ->as($file['original_name'])
                        ->withMime($file['mime_type'] ?? 'application/octet-stream');
                }
            }
        }

        return $attachments;
    }
}
