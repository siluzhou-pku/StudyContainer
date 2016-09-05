
# StudyContainer

container学习工程

siluzhou 账户 客户端修改

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
更多方法请看 [Install](https://github.com/siluzhou-pku/St)

## Basic Usage

container允许您注册服务。下面以类Someservice为例。
```
<?php

namespace Acme\Service;

class SomeService
{
    // ...
}


```
Container注册该服务：
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
更多用法请看[Basic Usage](https://github.com/siluzhou/StudyContainer/wiki/Basic-Uasge) 和[Advanced](https://github.com/siluzhou/StudyContainer/wiki/Advanced)文档 
## Documentation
- [Home](https://github.com/siluzhou-pku/StudyWiki/wiki/Container_Home)
- [Install](https://github.com/siluzhou-pku/StudyWiki/wiki/Container_Install)
- [Basic Usage](https://github.com/siluzhou-pku/StudyWiki/wiki/Container_Basic-Uasge)
- [Advanced](https://github.com/siluzhou-pku/StudyWiki/wiki/Container_Advanced)
- [thephpleague 中文](https://github.com/siluzhou-pku/StudyWiki/wiki/Container_thephpleaguez%E4%B8%AD%E6%96%87)

## License

StudyContainer is licensed under the MIT License
