Heureka php košík client
========================

Ukázka použiti API_HEUREKA
--------------------------

Inicializace
------------

```php
<?php
$container = new \Freema\HeurekaAPI\Api($apiKey);
```

GET payment/status
------------------

```php
$response = $container->getPaymentStatus()->setOrderId(22)->execute();

$result = $response->toArray();
```

PUT order/status
----------------
Nastavení stavu objednávy na Heurece.
Je důležité, aby každá změna objednávky byla přenesena zpět do Heureky. Jenom tak je možné zákazníkům zobrazit v jakém stavu se nachází jejich objednávka.     

```php
$response = $container  ->putOrderStatus()
                        ->setOrderId(22)
                        ->setStatus(1)
                        ->setTracnkingUrl('http://www.exmaple.com/?id=101010&transport')
                        ->setNote('test')
                        ->setExpectDeliver('2013-01-10')
                        ->execute();
```

PUT payment/status
------------------
Nastavení stavu platby na Heurece.
Tato metoda slouží k nastavení platby při dobírce nebo platbě v hotovosti na pobočce obchodu.
```php
$response = $container  ->putPaymentStatus()
                        ->setOrderId(22)
                        ->setStatus(1)
                        ->setDate('2013-01-10') // akceptuje i DateTime object 
                        ->execute();
```

GET order/status
----------------
Informace o stavu objednávky a interním čísle objednávky na Heurece.
```php
$response = $container  ->getOrderStatus()
                        ->setOrderId(22)
                        ->execute();
```

GET stores
----------------
Informace o pobočkách / výdejních místech, které má obchod uložené na Heurece.
```php
$response = $container->getStores()->execute();
```

GET shop/status
--------------
Informace o aktivaci obchodu v Košíku.
Slouží k zjištění zda je obchod spuštěn v Košíku či nikoliv. Pokud je Košík vypnutý z důvodu chyby v API nebo nějaké procesní chyby, je o tom napsáno v parametru message.
Informace o aktivaci / dekativaci jsou vždy na 30 minut uložné ve vyrovnávací paměti (cache). Pokud testujete stav obchodu pomocí cronu zvolte interval 30 minut a více.

```php
$response = $container->getShopStatus()->execute();
$response = $container->getStores()->execute();
```

POST order/note
---------------
Zaslání poznámky, které obchod vytvořil při procesu vyřizování objednávky.
Tyto poznámky se zobrazují zákazníkovi u objednávky v jeho profilu. 

```php
$response = $container->postOrderNote()->setOrderId(22)->setNote('test')->execute();
```

POST order/invoice
------------------
Zaslaní faktury (dokladu) k objednávce.
Obchody, které posílají faktury zákazníkům v elektronické podobě, ji musí zaslat také Heurece, tak aby je bylo možné opětovně poslat nebo umožnit jejich stažení v přehledu objednávek.
Maximální velikost souboru s fakturou je 3 MB a souboru musí být v PDF.
Tato metoda předpokládá multipart data u parametru file. POST požadavek by měl mít nastaven Content-type na multipart / form-data.

```php
$response = $container->postOrderInvoice()->setInvoiceFile('test.pdf')->setOrderId(22)->execute();
```