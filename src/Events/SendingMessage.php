<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 29.06.2018
 * Time: 16:30
 */

namespace Kagatan\SmsUkraine\Events;

use Kagatan\SmsUkraine\SmsUkraineClient;

class SendingMessage
{
    /**
     *  The SmsUkraine message.
     *
     * @var SmsUkraineClient
     */
    public $message;


    /**
     * SendingMessage constructor.
     * @param SmsUkraineClient $message
     */
    public function __construct(SmsUkraineClient $message)
    {
        $this->message = $message;
    }
}