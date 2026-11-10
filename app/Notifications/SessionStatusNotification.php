<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SessionStatusNotification extends Notification
{
    use Queueable;

    public $session;
    public $status;

    public function __construct($session, string $status)
    {
        $this->session = $session;
        $this->status = $status;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $tutorName = $this->session->tutor?->name
            ?? 'Your tutor';

        if ($this->status === 'confirmed') {
            $message = $tutorName
                . ' confirmed your tutoring session for '
                . $this->session->subject . '.';
        } elseif ($this->status === 'cancelled') {
            $message = $tutorName
                . ' declined your tutoring session request for '
                . $this->session->subject . '.';
        } else {
            $message = 'Your tutoring session status has changed.';
        }

        return [
            'session_id' => $this->session->id,
            'subject' => $this->session->subject,
            'status' => $this->status,
            'message' => $message,
        ];
    }
}
