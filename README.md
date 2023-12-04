# yii2-tpay
Payment system tpay.com Basic implementation


```
php yii migrate --migrationPath="@stitchua/tpay/migrations"
```

## Instalacja

Zalecany sposób instalacji przez [composer](http://getcomposer.org/download/)

Możesz uruchomić

```
php composer.phar require --prefer-dist ststichua/yii2-tpay 
```

lub dodać

```
"stitchua/yii2-tpay":"*"
```

do sekcji `require` twojego composer.json

Po instalacji pakietu należy uruchomić migrację (w konsoli):
```
php yii migrate --migrationPath="@stitchua/tpay/migrations"
```

## Konfiguracja

Do konfigurowania modułu służą:

- `merchantId` - ID konta w systemie płatnościowym Tpay
- `merchantCode` - Security code from Tpay panel
- `validateServerIP` - zmienna służąca do wyłączenia sprawdzenia dedykowanych IP serwerów serwisu Tpay (dla celów debugowania)

Przykładowa konfiguracja `config/web.php`:

```php
'tpay' => [
    'class' => 'stitchua\\tpay\\Tpay',
    'merchantId' => 77700,
    'merchantCode' => 'AT6oNO0F5ntQQQXxX',
    'validateServerIP' => false
],
```

### Jak korzystyać

Na dziś biblioteka realizyje generowania linku HTTP do płatności.

```php
    $tpayModule = Yii::$app->getModule('tpay');
    $basicPayload = new TpayBasicPayloadCommercialSale($this);
    $basicPayload->setExpirationDate(DateHelper::now()->addMinutes(2)->format('Y:m:d:H:i'));
    $basicPayload->setReturnUrl(Yii::$app->urlManager->createAbsoluteUrl(['/mobile/payment/paymentlandingpage', 'result' => 'success']));
    $basicPayload->setReturnErrorUrl(Yii::$app->urlManager->createAbsoluteUrl(['/site/paymentlandingpage', 'result' => 'error']));
    /** @var TpayNoApiPayload $payload */
    $payload = null;
    $link = (new IntegrationWithoutAPI($tpayModule))->getPaymentLink($basicPayload, $payload);
    if(!empty($link)){
        $this->updateAttributes([
            'fld_payment_crc' => $payload->crc,
            'fld_status' => self::STATUS_IN_PAYMENT,
        ]);
    }
    // Tutaj link już jest wygenerowany
    return $link;
```
Klasa `TpayBasicPayloadCommercialSale` powinna zrealizować interface `stitchua\tpay\base\ILinkPayload`
```php
class TpayBasicPayloadCommercialSale extends \yii\base\Model implements \stitchua\tpay\base\ILinkPayload
{

}
```