# Heureka Košík API Client

Modern PHP 8.1+ client for Heureka Košík API with full type safety and strict standards.

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue)](https://php.net)

## Requirements

- PHP 8.1 or higher
- ext-curl
- ext-json

## Installation

Install via [Composer](https://getcomposer.org):

```bash
composer require freema/heureka-kosik-api
```

## Framework Integration

### Nette Framework

The library provides seamless integration with Nette Framework through a DI Extension.

#### Installation

Register the extension in your `config.neon`:

```yaml
extensions:
    heurekaKosikApi: Freema\HeurekaAPI\Bridges\HeurekaKosikApiExtension

heurekaKosikApi:
    key: %env.HEUREKA_API_KEY%  # Recommended: use environment variable
    debug: false                 # Set to true for test API endpoint
    autowired: true             # Enable autowiring (default: true)
```

#### Usage in Nette

The API service is automatically registered in the DI container and can be autowired:

```php
<?php

declare(strict_types=1);

namespace App\Presenters;

use Freema\HeurekaAPI\Api;
use Nette\Application\UI\Presenter;

class OrderPresenter extends Presenter
{
    public function __construct(
        private Api $heurekaApi,
    ) {
    }

    public function actionUpdateStatus(int $orderId): void
    {
        $response = $this->heurekaApi->putOrderStatus()
            ->setOrderId($orderId)
            ->setStatus(1)
            ->execute();
    }
}
```

### Symfony Framework

The library includes a Symfony Bundle for easy integration with Symfony applications.

#### Installation

1. Register the bundle in `config/bundles.php`:

```php
<?php

return [
    // ... other bundles
    Freema\HeurekaAPI\Bundle\HeurekaKosikApiBundle::class => ['all' => true],
];
```

2. Create configuration file `config/packages/heureka_kosik_api.yaml`:

```yaml
heureka_kosik_api:
    api_key: '%env(HEUREKA_API_KEY)%'  # Use environment variable
    debug: false                        # Set to true for test API endpoint
```

3. Set your API key in `.env` or `.env.local`:

```bash
HEUREKA_API_KEY=your_api_key_here
```

#### Usage in Symfony

The API service is automatically registered and can be autowired or accessed via the service container:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Freema\HeurekaAPI\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private Api $heurekaApi,
    ) {
    }

    #[Route('/order/{id}/update-status', name: 'order_update_status')]
    public function updateStatus(int $id): Response
    {
        $response = $this->heurekaApi->putOrderStatus()
            ->setOrderId($id)
            ->setStatus(1)
            ->setTracnkingUrl('https://tracking.example.com/'. $id)
            ->execute();

        // Handle response...
        return new Response('Status updated');
    }
}
```

You can also access the service directly from the container:

```php
$api = $this->container->get('heureka_kosik_api');
// or
$api = $this->container->get(\Freema\HeurekaAPI\Api::class);
```

## Standalone Usage

The library can be used without any framework:

## Quick Start

### Initialization

```php
<?php

declare(strict_types=1);

use Freema\HeurekaAPI\Api;

$api = new Api('YOUR_API_KEY');

// For testing/debug mode:
$api = new Api('YOUR_API_KEY', debug: true);
```

## API Methods

### GET payment/status

Get payment status for an order.

```php
$response = $api->getPaymentStatus()
    ->setOrderId(22)
    ->execute();

$result = $response->toArray();

if ($api->getContainer()->hasError()) {
    $error = $api->getContainer()->getErrorMessage();
}
```

### PUT order/status

Update order status on Heureka. It's important that every order change is transferred back to Heureka so customers can see the current status of their orders.

```php
$response = $api->putOrderStatus()
    ->setOrderId(22)
    ->setStatus(1)
    ->setTracnkingUrl('https://www.example.com/?id=101010&transport')
    ->setNote('Objednávka je připravena k odeslání')
    ->setExpectDeliver('2025-01-15')
    ->execute();
```

### PUT payment/status

Update payment status on Heureka. This method is used for cash on delivery or cash payment at a store branch.

```php
use DateTime;

$response = $api->putPaymentStatus()
    ->setOrderId(22)
    ->setStatus(1)
    ->setDate('2025-01-15') // Accepts string or DateTime object
    ->execute();

// Or with DateTime:
$response = $api->putPaymentStatus()
    ->setOrderId(22)
    ->setStatus(1)
    ->setDate(new DateTime('2025-01-15'))
    ->execute();
```

### GET order/status

Get information about order status and internal order number on Heureka.

```php
$response = $api->getOrderStatus()
    ->setOrderId(22)
    ->execute();
```

### GET stores

Get information about branches/pickup locations that the shop has stored on Heureka.

```php
$response = $api->getStores()->execute();
```

### GET shop/status

Get information about shop activation in Košík. Used to determine whether the shop is running in Košík or not. If Košík is disabled due to an API error or process error, it's described in the message parameter.

**Note:** Activation/deactivation information is cached for 30 minutes. If testing shop status via cron, use an interval of 30 minutes or more.

```php
$response = $api->getShopStatus()->execute();
```

### POST order/note

Send a note that the shop created during the order processing. These notes are displayed to the customer with their order in their profile.

```php
$response = $api->postOrderNote()
    ->setOrderId(22)
    ->setNote('Zásilka bude doručena zítra dopoledne')
    ->execute();
```

### POST order/invoice

Send an invoice (receipt) for an order. Shops that send invoices to customers electronically must also send them to Heureka so they can be resent or made available for download in the order overview.

- Maximum file size: 3 MB
- Format: PDF only

```php
$response = $api->postOrderInvoice()
    ->setOrderId(22)
    ->setInvoiceFile('/path/to/invoice.pdf')
    ->execute();
```

## Development

### Code Quality Tools

```bash
# Run PHPStan (level 8 with strict rules)
composer phpstan

# Run PHP CS Fixer (check)
composer cs-check

# Run PHP CS Fixer (fix)
composer cs-fix

# Run tests
composer test
```

## Migration from v1.x

### Breaking Changes

1. **PHP Version**: Now requires PHP 8.1+
2. **Namespace Changes**: Request classes moved to `Freema\HeurekaAPI\Request\` namespace
3. **Type Safety**: All methods now have strict type hints and return types
4. **Removed**: Manual loader.php (use Composer autoload)

### Updated Code

**Before (v1.x):**
```php
$container = new \Freema\HeurekaAPI\Api($apiKey);
$response = $container->getOrderStatus()->setOrderId('22')->execute();
```

**After (v2.x):**
```php
$api = new \Freema\HeurekaAPI\Api($apiKey);
$response = $api->getOrderStatus()->setOrderId(22)->execute();
```

## License

This library is licensed under BSD-3-Clause, GPL-2.0-or-later, and GPL-3.0-or-later.