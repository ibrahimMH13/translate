

## Introduction

ibrhaim13/mdb-translate is laravel translation package using mongodb for static text that is simple,dynamic  and enjoyable to use.

## Official Documentation

## Install (Laravel ^8.0, ^9.0 )
Install via composer
```bash
composer require ibrhaim13/translate
```
## Publish Package 
will publish Package Components translate13 (config file), Migration file, view,  
```bash
php artisan vendor:publish --force --tag=translate13
```

## Dependents:  
you should install laravel on of Starter Kits auth package like auth/ui or laravel-breeze or other cause should this feature for admins.
we are also Dependent to laravel view app layout if you want to make your custom view you do not need it at all.
## Basic Configure Package  
Run migrate
```bash
php artisan migrate
```
add middleware for web middleware group for add local to url path 
```bash
# app/Http/Kernel.php

protected $middlewareGroups = [
        'web' => [
        ...,
        Ibrhaim13\Translate\Http\Middleware\Web\Localization::class,
        ...
        ]
```
will change local of app once change it at url.

add prefix to routes via Route Service Provider of application
```bash
# app/Providers/RouteServiceProvider.php
# boot function inside route callback funcation add ->prefix(Localization::routePrefix())
      Route::middleware('web')->prefix(Localization::routePrefix())
           ->group(base_path('routes/web.php'));
```
## Advance Configure Package
you can be custom route ,prefix,add new language and add your middlewares as you like  view, and you should add  translate page route into your navbar of app, so you can access page
you can add new translate group via extend the model and overwrite the group 
```bash
# app/Models/YourTranslateModelExtendFromPackageModel.php
    public static array $groups = [
        'str_public',
        'str_admin',
        //here add your new group as you like
    ];
```

## How you can use
after set up your configuration you can access translate page 
to add new keys so you can translate it from admin panel
```bash
#first segment is a group name
#secand segment is translated key
__('str_public.key name');
```
by default there two group name ```str_public```,```str_admin```,after add the key before open translate admin page you must open the page there have this key so laravel application loaded
<br>
<br>
to access translate admin panel page
```bash
http://yourdomain.com/en/translate
```
then click on generate button to generate static translate files after edit your translation
##NOTE:
    YOUR SERVER NEED PERMISSION TO CRAETE TRANSLATIONS FILES
## Security Vulnerabilities

e-mail us at i.musabah92@gmail.com
## License

ibrhaim13/translate is open-sourced software licensed under the [MIT license](LICENSE.md).
