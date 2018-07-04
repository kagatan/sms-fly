<?php

namespace Kagatan\SmsUkraine\Events;

use Kagatan\SmsUkraine\SmsUkraineClient;

class MessageWasSent
{
    /**
     * The sms message.
     *
     * @var SmsUkraineClient
     */
    public $message;


    /**
     * The Api response implementation.
     *
     * @var
     */
    public $response;


    /**
     * MessageWasSent constructor.
     *
     * MessageWasSent constructor.
     * @param SmsUkraineClient $message
     * @param $response
     */
    public function __construct(SmsUkraineClient $message, $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}