<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\BloodRequest;

class UrgentBloodRequestNotification extends Notification
{
    use Queueable;

    public $bloodRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(BloodRequest $bloodRequest)
    {
        $this->bloodRequest = $bloodRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'blood_request_id' => $this->bloodRequest->id,
            'required_type' => $this->bloodRequest->required_type,
            'city' => $this->bloodRequest->city,
            'hospital' => $this->bloodRequest->hospital,
            'message' => "طلب دم عاجل لفصيلة {$this->bloodRequest->required_type} في مدينتك ({$this->bloodRequest->city}) بمستشفى {$this->bloodRequest->hospital}.",
        ];
    }
}
