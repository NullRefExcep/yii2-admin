Yii2 Admin
===============
[![Latest Stable Version](https://poser.pugx.org/nullref/yii2-admin/v/stable)](https://packagist.org/packages/nullref/yii2-admin) [![Total Downloads](https://poser.pugx.org/nullref/yii2-admin/downloads)](https://packagist.org/packages/nullref/yii2-admin) [![Latest Unstable Version](https://poser.pugx.org/nullref/yii2-admin/v/unstable)](https://packagist.org/packages/nullref/yii2-admin) [![License](https://poser.pugx.org/nullref/yii2-admin/license)](https://packagist.org/packages/nullref/yii2-admin)

Module for administration

Check extended version of this module at [this link](https://github.com/NullRefExcep/yii2-full-admin)

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

Then You have run console command for install this module and run migrations:

```
php yii module/install admin
php yii modules-migrate
```

Pay attention that if you don't use our [application template](https://github.com/NullRefExcep/yii2-boilerplate) 
it needs to change config files structure to have ability run commands that show above.

Please check this [documentation section](https://github.com/NullRefExcep/yii2-core#config-structure)

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

### Admin Controller

If you use `IAdminController` interface in controller, admin layout and default access rule will be set in controller before action.

### Modules system 

This module integrated in system which contain other useful components. [View details](https://github.com/NullRefExcep/yii2-core)

### Overriding

Example:

```php
/** module config **/

'admin' => [
   'class' => 'nullref\admin\Module',
   'adminModel' => 'app\models\Admin', // admin model class
   'controllerMap' => [  //controllers
      'user' => 'app\modules\admin\controllers\UserController',
      'main' => 'app\modules\admin\controllers\MainController',
   ],
   'components' => [  //menu builder
      'menuBuilder' => 'app\\components\\MenuBuilder',
   ],
],
```

And [translations](https://github.com/NullRefExcep/yii2-core#translation-overriding)

