<?php

namespace Illuminate\Notifications\Channels;

use Illuminate\Notifications\Notification;
use in7rude\Devino\Client as DevinoClient;
use in7rude\Devino\SMSError_Exception;

class DevinoSmsChannel
{
    /**
     * The Nexmo client instance.
     *
     * @var DevinoClient
     */
    protected $devino;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Nexmo channel instance.
     *
     * @param DevinoClient $devino
     * @param string       $from
     *
     */
    public function __construct(DevinoClient $devino, $from)
    {
        $this->from = $from;
        $this->devino = $devino;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @return array|void
     * @throws SMSError_Exception
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('devino', $notification)) {
            return;
        }

        $message = $notification->toDevino($notifiable);

        return $this->devino->send($this->from, $to, trim($message));
    }
}
