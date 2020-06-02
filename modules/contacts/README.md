mod-contacts
===========
Module for PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-contacts/v/stable)](https://packagist.org/packages/panix/mod-contacts) [![Total Downloads](https://poser.pugx.org/panix/mod-contacts/downloads)](https://packagist.org/packages/panix/mod-contacts) [![Monthly Downloads](https://poser.pugx.org/panix/mod-contacts/d/monthly)](https://packagist.org/packages/panix/mod-contacts) [![Daily Downloads](https://poser.pugx.org/panix/mod-contacts/d/daily)](https://packagist.org/packages/panix/mod-contacts) [![Latest Unstable Version](https://poser.pugx.org/panix/mod-contacts/v/unstable)](https://packagist.org/packages/panix/mod-contacts) [![License](https://poser.pugx.org/panix/mod-contacts/license)](https://packagist.org/packages/panix/mod-contacts)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer require --prefer-dist panix/mod-contacts "*"
```

or add

```
"panix/mod-contacts": "*"
```

to the require section of your `composer.json` file.


Add to web config.
```
    'modules' => [
        'contacts' => ['class' => 'app\modules\contacts\Module'],
    ],
```