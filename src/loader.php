<?php

/**
 * include container!
 */
require_once dirname(__FILE__) . '/Api.php';
require_once dirname(__FILE__) . '/IContainer.php';
require_once dirname(__FILE__) . '/Container.php';
require_once dirname(__FILE__) . '/exception.php';

require_once dirname(__FILE__) . '/Request/interfaces.php';
require_once dirname(__FILE__) . '/Request/GetOrderStatus.php';
require_once dirname(__FILE__) . '/Request/GetPaymentStatus.php';
require_once dirname(__FILE__) . '/Request/GetShopStatus.php';
require_once dirname(__FILE__) . '/Request/GetStores.php';
require_once dirname(__FILE__) . '/Request/PostOrderInvoice.php';
require_once dirname(__FILE__) . '/Request/PostOrderNote.php';
require_once dirname(__FILE__) . '/Request/PutOrderStatus.php';
require_once dirname(__FILE__) . '/Request/PutPaymentStatus.php';

require_once dirname(__FILE__) . '/Response.php';

if(class_exists('Nette\DI\CompilerExtension')) {
    require_once dirname(__FILE__) . '/Bridges/HeurekaKosikApiExtension.php';
}

/**
 * Check PHP configuration.
 */
if (version_compare(PHP_VERSION, '5.2.0', '<')) {
    throw new Exception('Heureka api needs PHP 5.2.0 or newer.');
}

if (!function_exists('curl_version')) {
    throw new Exception('Heuareka api need CURL extension.');
}
