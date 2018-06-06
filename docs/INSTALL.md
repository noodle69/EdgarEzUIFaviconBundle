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
        new Edgar\EzUISitesBundle\EdgarEzUISitesBundle(),
        new Edgar\EzUIFaviconBundle\EdgarEzUIFaviconBundle(),
        // ...
    );
}
```

## Add routing

Add to your global configuration app/config/routing.yml

```yaml
edgar.ezuifavicon:
    resource: '@EdgarEzUIFaviconBundle/Resources/config/routing.yml'
    prefix: /_favicons
    defaults:
        siteaccess_group_whitelist: 'admin_group'
```

### Configure bundle

```yaml
# app/config/ezplatform.yml
edgar_ez_ui_favicon:
    system:
        admin_group:
            api_key: ... #required
            versioning: true
            favicon_design:
                desktop_browser: []
                ios:
                    picture_aspect: "background_and_margin"
                    margin: 0
                    background_color: "#fff"
                windows:
                    picture_aspect: "white_silhouette"
                    background_color: "#fff"
                firefox_app:
                    picture_aspect: "circle"
                    keep_picture_in_circle: true
                    circle_inner_margin: 5
                    background_color: "#fff"
                    manifest:
                        app_name: "bar"
                        app_description: "bar description"
                android_chrome:
                    picture_aspect: "shadow"
                    theme_color: "#fff"
                    manifest:
                        name: "bar"
                        display: "standalone"
                        orientation: "portrait"
                safari_pinned_tab:
                    picture_aspect: "black_and_white"
                    threshold: 60
                    theme_color: "#fff"
                coast:
                    picture_aspect: "background_and_margin"
                    background_color: "#fff"
                    margin: 4
                open_graph:
                    picture_aspect: "background_and_margin"
                    background_color: "#fff"
                    margin: 4
                    ratio: "1.91:1"
                yandex_browser:
                    background_color: "#fff"
                    manifest:
                        show_title: true
                        version: "1.0"
```

* api_key : visit RealFaviconGenerator website to obtain your own API Key for Non-interactive mode
* master_picture : define path of image model used to generate favicons
* package_dest : define were favicon images would be uploaded
* favicons_view : define which twig template would be used to be completed with all head links favicons
* versioning : define if GET parameter would be adder after favicons path
* favicon_design : all parameters are not implemented, see documentation (http://realfavicongenerator.net/api/non_interactive_api#.VhrCqnrtlBc)
