# EdgarEzUIFaviconBundle

## Twig extension

In your layout twig template, add twig extension 'edgarez_favicons'

```twig
<!doctype html>
<html lang="{{ app.request.locale|replace({'_': '-'}) }}">
<head>
    {{ edgarez_favicons(ezpublish.siteaccess.name) }}
    ...
</head>
<body>
{% block content %}{% endblock %}
</body>
</html>
```
