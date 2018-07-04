<?php

namespace Kagatan\SmsFly;

use Illuminate\Notifications\Notification;
use Kagatan\SmsFly\Exceptions\MissingNotificationRouteException;


class SmsFlyChannel
{
    /**
     * @var SmsFlyClient
     */
    protected $client;

    /**
     * Create a new SMS Fly channel instance.
     *
     * SmsFlyChannel constructor.
     *
     * @param SmsFlyClient $client
     */
    public function __construct(SmsFlyClient $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('SmsFly')) {
            return;
        }

        if (!method_exists($notification, $route = 'toSmsFly')) {
            throw new MissingNotificationRouteException(sprintf('Missing notification route "%s"', $route));
        }

        $message = $notification->{$route}($notifiable);

        // Overwrite 'to' property, if route to the notification does not set it
        if ($message->to === null) {
            $message->to($to);
        }

        $result = $this->client->send($message->toArray());

        return $result;
    }
}