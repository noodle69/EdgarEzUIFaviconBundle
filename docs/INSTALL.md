# EdgarEzUIFaviconBundle

## Installation

### Get the bundle using composer

Add EdgarEzUIFaviconBundle by running this command from the terminal at the root of
your symfony project:

```bash
composer require edgar/ez-uifavicon-bundle
```

## Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Edgar\EzUIFaviconBundle\EdgarEzUIFaviconBundle(),
        // ...
    );
}
```
