<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BloodRequest;

class RequestStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $bloodRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(BloodRequest $bloodRequest)
    {
        $this->bloodRequest = $bloodRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تحديث بخصوص طلب الدم الخاص بك - LifeDrop',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // For simplicity, we can pass a simple view or use markdown
        return new Content(
            htmlString: '<h2>مرحباً!</h2><p>لقد تم تحديث حالة طلب الدم الخاص بك (رقم التتبع: <strong>' . $this->bloodRequest->tracking_id . '</strong>) لتصبح: <strong>' . $this->bloodRequest->status . '</strong></p><p>شكراً لاستخدامك LifeDrop.</p>'
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
