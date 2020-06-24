# Spryker - QuasirisCatchingCategoryEvents

This library is used to catching events about product from category (abstract, concrete, categories) as like:
- assign, 
- unassign

And sending it to custom api url (POST method).

Data comes to api 

```json
API_URL_MAIN:
{
    "abstract": {}, 
    "concrete": {}, 
    "categories": {
        "categories": [] 
    }
}
API_URL_TESTING:
{
    "status": "SUCCESS",
    "params": {
        "date": "23.06.20 10:26:06",
        "listenerName": "QuasirisCatchingCategoryEventsListener",
        "eventName": "Product.product_abstract.after.update",
        "abstract": {
            
        },
        "concrete": [],
        "categories": {
            "categories": []
        },
        "productId": "//id of product",
        "type": "products"
    },
    "eventName": "Product.product_abstract.after.update",
    "request_form_params_main_api": "params with goes to api",
    "response_from_main_api": {},
    "url_main_api": "API_URL_MAIN",
    "url_testing_api": "API_URL_TESTING",
    "product_id": "//id of product"
}

```

## Installation

If you dont have install composer go to [composer website](https://getcomposer.org/download/) and install it.

Type in your project terminal:

```bash
composer require quasiris/quasiris-catching-category-events
```

## Usage

After installation, go to Pyz\Zed\Event\EventDependencyProvider.php;

Import subscriber:

```php
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Communication\Plugins\Event\Subscriber\QuasirisCatchingCategoryEventsSubscriber;


```

next in getEventSubscriberCollection() method, above return $eventSubscriberCollection;, register events to watch:

```php
$eventSubscriberCollection->add(new QuasirisCatchingCategoryEventsSubscriber());

```

All implementation Pyz\Zed\Event\EventDependencyProvider.php:

```php
<?php
// Pyz\Zed\Event\EventDependencyProvider.php
namespace Pyz\Zed\Event;

use ...;
.
.
.
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Communication\Plugins\Event\Subscriber\QuasirisCatchingCategoryEventsSubscriber;

class EventDependencyProvider extends SprykerEventDependencyProvider
{
    /**
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getEventListenerCollection()
    {
        return parent::getEventListenerCollection();
    }

    /**
     * @return \Spryker\Zed\Event\Dependency\EventSubscriberCollectionInterface
     */
    public function getEventSubscriberCollection()
    {
        .
        .
        .
        .
        .
        $eventSubscriberCollection->add(new QuasirisCatchingCategoryEventsSubscriber());

        return $eventSubscriberCollection;
    }
}

```

Next go to config/Shared/config_default.php

Import constant from plugin and add constant:

```php
// config/Shared/config_default.php
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Shared\QuasirisCatchingCategoryEventsConstants;

//create this
$config[QuasirisCatchingCategoryEventsConstants::MY_SETTING] = [
    'API_URL_MAIN' => 'main url where data goes',
    'API_URL_TESTING' => 'testing url where data goes with additional informations'
];


$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
    'Quasiris', //add this in KernelConstants::PROJECT_NAMESPACES
];
```

Info: 
API_URL_MAIN and API_URL_TESTING working separatly you can add only one of them  ex.
```php
// config/Shared/config_default.php
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Shared\QuasirisCatchingCategoryEventsConstants;

$config[QuasirisCatchingCategoryEventsConstants::MY_SETTING] = [
    'API_URL_MAIN' => 'main url where data goes'
];
------------------------ Different example ------------------------------
// config/Shared/config_default.php
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Shared\QuasirisCatchingCategoryEventsConstants;

$config[QuasirisCatchingCategoryEventsConstants::MY_SETTING] = [
    'API_URL_TESTING' => 'testing url where data goes with additional informations'
];


```

## License
[MIT](https://choosealicense.com/licenses/mit/)