Yii2 Admin
===============
[![Latest Stable Version](https://poser.pugx.org/nullref/yii2-admin/v/stable)](https://packagist.org/packages/nullref/yii2-admin) [![Total Downloads](https://poser.pugx.org/nullref/yii2-admin/downloads)](https://packagist.org/packages/nullref/yii2-admin) [![Latest Unstable Version](https://poser.pugx.org/nullref/yii2-admin/v/unstable)](https://packagist.org/packages/nullref/yii2-admin) [![License](https://poser.pugx.org/nullref/yii2-admin/license)](https://packagist.org/packages/nullref/yii2-admin)

Module for administration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nullref/yii2-admin "*"
```

or add

```
"nullref/yii2-admin": "*"
```

to the require section of your `composer.json` file.


### Admin Menu

For adding items to admin menu you have to implement IAdminModule interface, e.g.:

```php
public static function getAdminMenu()
   {
       return [
           'label' => \Yii::t('admin', 'Subscription'),
           'icon' => 'envelope',
           'items' => [
               'emails' => ['label' => \Yii::t('app', 'Subscribers'), 'icon' => 'envelope-o', 'url' => ['/subscription/email/index']],
               'messages' => ['label' => \Yii::t('app', 'Messages'), 'icon' => 'envelope-o', 'url' => ['/subscription/message/index']],
           ]
       ];
   }
```
