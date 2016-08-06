
# StudyContainer

container学习工程

## Highlights

- Simple API
- Composer ready, [PSR-2] and [PSR-4] compliant
- Fully documented
- Demo
- Unit



## System Requirements

You need:

- **PHP >= 5.4** , but the latest stable version of PHP is recommended

- **league/container: ^2.2**
       

## Install
可以使用composer安装

```
composer require league/container
```
现在大部分框架都包括Composer，您需要注意包含以下文件：
```
<?php

// include the Composer autoloader
require 'vendor/autoload.php';

```

您也自行注册自动导入函数，不用composer来使用container

```
spl_autoload_register(function ($class) {
    $prefix = 'League\\Container\\';
    $base_dir = __DIR__ . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
```
或者使用其余PSR-4兼容自动导入。

## Basic Usage

container允许您注册服务，无论是否有他们以供将来检索的依赖项(?with or without their dependencies for later retrieval.)
```
<?php

namespace Acme\Service;

class SomeService
{
    // ...
}


```
现在Container可以提供多种方法可以注册该服务：
```
<?php

$container = new League\Container\Container;

// register the service as a prototype against an alias
$container->add('service', 'Acme\Service\SomeService');

// now to retrieve this service we can just retrieve the alias
// each time we `get` the service it will be a new instance
$service1 = $container->get('service');
$service2 = $container->get('service');

var_dump($service1 instanceof Acme\Service\SomeService); // true
var_dump($service1 === $service2); // false
```

```
<?php

$container = new League\Container\Container;

// register the service as a prototype against the fully qualified classname
$container->add('Acme\Service\SomeService');

// now to retrieve this service we can just retrieve the classname
// each time we `get` the service it will be a new instance
$service1 = $container->get('Acme\Service\SomeService');
$service2 = $container->get('Acme\Service\SomeService');

var_dump($service1 instanceof Acme\Service\SomeService); // true
var_dump($service1 === $service2); // false
```
有些情况下你希望每次获得的服务是同一个实例，这也有两种方法，作为分享说明，或者直接注册一个已有的对象实例。
```
<?php

$container = new League\Container\Container;

// register the service as shared against the fully qualified classname
$container->share('Acme\Service\SomeService');

// you retrieve the service in exactly the same way, however, each time you
// call `get` you will retrieve the same instance
$service1 = $container->get('Acme\Service\SomeService');
$service2 = $container->get('Acme\Service\SomeService');

var_dump($service1 instanceof Acme\Service\SomeService); // true
var_dump($service1 === $service2); // true
```

```
<?php

$container = new League\Container\Container;

// register the service as an instance against an alias
$container->add('service', new Acme\Service\SomeService);

// you retrieve the service in exactly the same way, however, each time you
// call `get` you will retrieve the same instance
$service1 = $container->get('Acme\Service\SomeService');
$service2 = $container->get('Acme\Service\SomeService');

var_dump($service1 instanceof Acme\Service\SomeService); // true
var_dump($service1 === $service2); // true
```
## Documentation
- [中文文档](https://github.com/siluzhou/StudyContainer/wiki/thephpleague%E4%B8%AD%E6%96%87)

## License

StudyContainer is licensed under the MIT License
