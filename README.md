## System information

This module adds System section to the administration panel which contains useful system information and logs 

## Pre-installation
This package is part of Netcore CMS ecosystem and is only functional in a project that has following packages installed:

https://github.com/netcore/netcore

https://github.com/netcore/module-admin

https://github.com/netcore/module-user

https://github.com/nWidart/laravel-modules

## Installation
 
 Require this package with composer:
 ```$xslt
 composer require netcore/module-system
```
 Publish config, assets, migrations. Migrate and seed:
 
 ```$xslt
 php artisan module:publish System
 php artisan module:publish-migration System
 php artisan migrate
 php artisan module:seed System
```

## Usage

System section:
![Menus](https://www.dropbox.com/s/icstuu64jhrnrc7/Screenshot%202018-02-16%2018.25.44.png?raw=1)

You can access the system functionality with core()

Get current server information
```PHP
core()->systemInfo();
```

Get current users browser
```PHP
core()->browser();
```

Get current users operating system
```PHP
core()->os();
```

Get current users IP
```PHP
core()->userIp();
```

Useful log functions
```PHP
core()->error();
```
```PHP
core()->warning();
```
```PHP
core()->info();
```
```PHP
core()->debug();
```