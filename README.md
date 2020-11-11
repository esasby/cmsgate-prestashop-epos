## Модуль интеграции с CMS Prestashop  (v1.7)

Данный модуль обеспечивает взаимодействие между интернет-магазином на базе CMS **Prestashop** и сервисом платежей [E-POS](www.e-pos.by).
После установки модуля для клиента будут доступны два новых способа оплаты: оплата через ЕРИП (по QR-коду) и оплата картой (через сервис [webpay](www.webpay.by)). 
Технически оба варианта добавляются счета в ЕРИП через сервис E-POS, но второй способ более очевидно перенаправляет клиента к оплате счета картой 
и не содержит инструкций по оплате в ЕРИП и QR-код. 

### Требования ###
1. PHP 5.6 и выше 
1. Библиотека Curl 

### Инструкция по установке:
1. Создайте резервную копию вашего магазина и базы данны
1. Установите модуль [ps_epos.zip](https://bitbucket.org/esasby/cmsgate-prestashop-epos/raw/master/ps_epos.zip) с помощью __Module  -> Module Manager -> Загрузить модуль__

## Инструкция по настройке
1. Перейдите к настройке плагина через меню __Module  -> Module Manager -> Прочее (Other)__
1. Напротив модуля EPOS нажмите «Настроить».
1. Укажите обязательные параметры
* EPOS процессинг - выбор организации, выполняющей интеграцию с EPOS
    * Идентификатор клиента – Ваш персональный логи для работы с сервисом EPOS
    * Секрет – Ваш секретный ключ для работы с сервисом EPOS
    * Код ПУ – код поставщика услуги в системе EPOS
    * Код услуги EPOS – код услуги у поставщика услуг в системе EPOS (один ПУ может предоставлять несколько разных услуг)
    * Код торговой точки – код торговой точки ПУ (у одного ПУ может быть несколько торговых точек)
    * Debug mode - запись и отображение дополнительных сообщений при работе модуля
    * Sandbox - перевод модуля в тестовый режим работы. В этом режиме счета выставляются в тестовую систему
    * Использовать номер заказа - если включен, то в ЕРИП будет выставлен счет с локальным номером заказа (orderNumber), иначе с локальным идентификатором (orderId)
    * Срок действия счета - как долго счет, будет доступен в ЕРИП для оплаты    
    * Статус при выставлении счета  - какой статус выставить заказу при успешном выставлении счета в ЕРИП (идентификатор существующего статуса из Магазин > Настройки > Статусы)
    * Статус при успешной оплате счета - какой статус выставить заказу при успешной оплате выставленного счета (идентификатор существующего статуса)
    * Статус при отмене оплаты счета - какой статус выставить заказу при отмене оплаты счета (идентификатор существующего статуса)
    * Статус при ошибке оплаты счета - какой статус выставить заказу при ошибке выставленния счета (идентификатор существующего статуса)
    * Секция "Инструкция" - если включена, то на итоговом экране клиенту будет доступна пошаговая инструкция по оплате счета в ЕРИП
    * Секция QR-code - если включена, то на итоговом экране клиенту будет доступна оплата счета по QR-коду
    * Секция Webpay - если включена, то на итоговом экране клиенту отобразится кнопка для оплаты счета картой (переход на Webpay)
    * Текст успешного выставления счета - текст, отображаемый кленту после успешного выставления счета. Может содержать html. В тексте допустимо ссылаться на переменные @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address
    * Название способа оплаты - название, показываемое клиенту при оформлении заказа на этапе выбора способы оплаты заказа
    * Описание способа оплаты - название, показываемое клиенту при оформлении заказа на этапе выбора способы оплаты заказа
1. Сохраните изменения.

### Внимание!
* Для автоматического обновления статуса заказа (после оплаты клиентом выставленного в ЕРИП счета) необходимо сообщить в службу технической поддержки сервиса «Хуткi Грош» адрес обработчика:
    ```
    http://mydomen.my/prestashop/ru/module/ps_epos/callback
    ```
* Модуль ведет лог файл по пути _site_root/modules/ps_epos/vendor/esas/cmsgate-core/logs/cmsgate.log_
Для обеспечения **безопасности** необходимо убедиться, что в настройках http-сервера включена директива _AllowOverride All_ для корневой папки.

### Тестовые данные
Для настрой оплаты в тестовом режиме
 * воспользуйтесь данными для подключения к тестовой системе, полученными при регистрации в EPOS
 * включите в настройках модуля режим "Песочницы" ("Sandbox")
_Разработано и протестировано с Prestashop v1.7.6_


