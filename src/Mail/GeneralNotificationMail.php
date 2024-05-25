<?php

namespace Adminetic\Notify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GeneralNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public $email;

    public $subject;

    public $email_message;

    protected $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $email_message, $attachment = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->email_message = $email_message;
        $this->attachment = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), title()),
            replyTo: [
                new Address($this->email, $this->name),
            ],
            subject: $this->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notify::admin.mail.general_notification_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (! is_null($this->attachment)) {
            if (is_array($this->attachment)) {
                foreach ($this->attachment as $key => $attachment) {
                    $attachments[] = Attachment::fromData(fn () => $attachment, $key.'.pdf');
                }

                return $attachments;
            }

            return [
                Attachment::fromData(fn () => $this->attachment, 'attachment.pdf'),
            ];
        }

        return [];
    }
}
