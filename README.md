<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Канал уведомлений для сервиса "SMS-fly"

Используя данный пакет вы сможете легко интегрировать SMS уведомления в ваше Laravel-приложение, для отправки которых используется сервис "[SMS-fly][sms-fly_home]".

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require kagatan/sms-fly
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].


Если вы используете Laravel версии 5.5 и выше, то сервис-провайдер данного пакета будет зарегистрирован автоматически. В противном случае вам необходимо самостоятельно зарегистрировать сервис-провайдер в секции `providers` файла `./config/app.php`:

```php
'providers' => [
    // ...
   Kagatan\SmsFly\SmsFlyServiceProvider::class,
]
```

Добавим фасад:

```php
 'aliases' => [
    ...
    'SmsFly' => Kagatan\SmsFly\Facades\SmsFly::class
]
```

Добавим в файл  `config/services.php` :
```php
// config/services.php
...
'sms-fly' => [
        'login'    => function_exists('env') ? env('SMSFLY_LOGIN', '') : '',
        'password' => function_exists('env') ? env('SMSFLY_PASSWORD', '') : '',
        'from'     => function_exists('env') ? env('SMSFLY_FROM', '') : '',
    ],
...
```

Для публикации провайдера:
```bash
php artisan vendor:publish --provider="Kagatan\SmsFly\SmsFlyServiceProvider"
```

# Настройка
После установки вам необходимо изменить файл `./.env` добавив ключи

```ini
SMSFLY_LOGIN=xxxxx

SMSFLY_PASSWORD=xxxxx

SMSFLY_FROM=SENDER-NAME
```
 

## Upgrading
 
```
composer update kagatan/sms-fly
```
 
## Использование

Базовый пример отправки SMS уведомлений с использованием функционала нотификаций в Laravel-приложениях:


Доступные к использованию методы у объекта SmsFlyMessage:

Имя метода   | Описание
------------ | --------
`from()`     | Имя отправителя (опционально)
`to()`       | Номер телефона получателя (опционально)
`content()`  | Текст сообщения
`startTime()`| Время начала отправки сообщения (опционально)
`endTime()`  | Время окончания отправки сообщения (опционально)
`lifeTime()` | Время, в течении которого оператор будет осуществлять попытки доставки сообщения абоненту в часах (опционально)
`rate()`     | Скорость отправки сообщения(й) в количестве сообщений в минуту (опционально)
`desc()`     | Описание рассылки (отображается в веб интерфейсе). (опционально)
`login()`    | API логин, для переопределения параметров из config(опционально)
`password()` | API пароль, для переопределения параметров из config(опционально)
`toJson()`   | Обьект на выходе в JSON
`toArray()`  | Объект на выходе в массиве



Пример класса оповещения:

```php
<?php

use Illuminate\Notifications\Notification;
use Kagatan\SmsFly\SmsFlyChannel;
use Kagatan\SmsFly\SmsFlyMessage;

/**
 * Notification object.
 */
class InvoicePaid extends Notification
{
    /**
     * Get the notification channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return [SmsFlyChannel::class];
    }

    /**
     * Get the SMS Fly Message representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return SmsFlyMessage
     */
    public function toSmsFly($notifiable)
    {
        return SmsFlyMessage::create()
            ->content('Some SMS notification message');
    }
}

```

В своей нотифицируемой моделе обязательно добавьте метод `routeNotificationForSmsFly()`, который возвращает номер телефона или массив телефонных номеров.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the SmsFly channel.
     *
     * @param $notifiable
     * @return string
     */
    public function routeNotificationForSmsFly($notifiable)
    {
        return $this->phone;
    }
}

```


**Пример c использованием Notifiable Trait:**

```php
$user->notify(new InvoicePaid());
```


**Пример c использованием Notification Facade:**

```php
Notification::send($users, new InvoicePaid());
```

**Пример отправки SMS с использованием  фасадов(без использования Notification):**

```php
<?php

use Kagatan\SmsFly\Facades\SmsFly;
use Kagatan\SmsFly\SmsFlyMessage;

public function test(){

        $message = SmsFlyMessage::create()
            ->content("Example sending SMS.")
            ->to("380987654210")
            ->from("WiFi-POINT")
            ->toArray();

        $id = SmsFlyMessage::send($message);
        
        echo $id;
}
```

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].


[getcomposer]:https://getcomposer.org/download/
[sms-fly_home]:https://sms-fly.ua/
[link_license]:https://github.com/kagatan/sms-fly/blob/master/LICENSE
