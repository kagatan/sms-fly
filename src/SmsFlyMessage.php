<?php

namespace Kagatan\SmsFly;


class SmsFlyMessage
{
    /**
     * API Login
     *
     * @var
     */
    public $login;


    /**
     * API Password
     *
     * @var
     */
    public $password;


    /**
     * Время начала отправки сообщения(й). Формат AUTO или YYYY-MM-DD HH:MM:SS.
     * Система допускает поправку времени в 5 минут.  Формат для PHP “Y-m-d H:i:s”).
     * При выборе значения AUTO - будет выставлено текущее системное время - немедленная отправка.
     *
     * @var string
     */
    public $start_time = 'AUTO';


    /**
     * Время окончания отправки сообщения(й),  Формат AUTO или YYYY-MM-DD HH:MM:SS.
     * Не может быть раньше времени начала отправки. (формат для PHP “Y-m-d H:i:s”).
     * Можно использовать значение AUTO для автоматического расчета времени системой.
     *
     * @var string
     */
    public $end_time = 'AUTO';


    /**
     * «срок жизни сообщения(й)» (время, в течении которого оператор будет осуществлять
     * попытки доставки сообщения абоненту) в часах.
     * Допускаются только целые значения в диапазоне от 1 до 24.
     *
     * @var string
     */
    public $lifetime = '24';


    /**
     * Скорость отправки сообщения(й) в количестве сообщений в минуту.
     * Допускаются только целые значения в диапазоне от 1 до 120.
     * Учитывается только для групповых рассылок.
     *
     * @var string
     */
    public $rate = '120';


    /**
     * Описание рассылки (отображается в веб интерфейсе).
     * На саму рассылку никак не влияет. Можно оставлять пустым.
     *
     * @var string
     */
    public $desc = '';


    /**
     * The text content of the message.
     *
     * @var string|null
     */
    public $message;


    /**
     * Receiver phone number.
     *
     * @var string|null
     */
    public $to;


    /**
     * Sender name. Leave 'null' for using value from settings.
     *
     * @var string|null
     */
    public $from;


    /**
     * Static factory method.
     *
     * @param mixed ...$arguments
     *
     * @return static|self
     */
    public static function create(...$arguments)
    {
        return new static(...$arguments);
    }


    /**
     * Set login
     *
     * @param $login
     * @return $this
     */
    public function login($login)
    {
        $this->login = (string)$login;
        return $this;
    }


    /**
     * Set password
     *
     * @param $password
     * @return $this
     */
    public function password($password)
    {
        $this->password = (string)$password;
        return $this;
    }


    /**
     * Set start_time
     *
     * @param $start_time
     * @return $this
     */
    public function startTime($start_time)
    {
        $this->start_time = (string)$start_time;
        return $this;
    }


    /**
     * Set end_time
     *
     * @param $end_time
     * @return $this
     */
    public function endTime($end_time)
    {
        $this->end_time = (string)$end_time;
        return $this;
    }


    /**
     * Set lifetime
     *
     * @param $lifetime
     * @return $this
     */
    public function lifeTime($lifetime)
    {
        $this->lifetime = (string)$lifetime;
        return $this;
    }


    /**
     * Set a rate.
     *
     * @param $rate
     * @return $this
     */
    public function rate($rate)
    {
        $this->rate = (string)$rate;
        return $this;
    }


    /**
     * Set a desc.
     *
     * @param $desc
     * @return $this
     */
    public function desc($desc)
    {
        $this->desc = (string)$desc;
        return $this;
    }


    /**
     * Set a sender name.
     *
     * @param string $sender_name
     *
     * @return static|self
     */
    public function from($sender_name)
    {
        $this->from = (string)$sender_name;
        return $this;
    }

    /**
     * Set receiver phone number (the message should be sent to).
     *
     * @param string $phone_number
     *
     * @return static|self
     */
    public function to($phone_number)
    {
        $this->to = (string)$phone_number;
        return $this;
    }

    /**
     * Set the content of SMS message.
     *
     * @param string $content
     *
     * @return static|self
     */
    public function content($content)
    {
        $this->message = (string)$content;
        return $this;
    }


    /**
     *  To JSON
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }


    /**
     * To Array
     *
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }
}