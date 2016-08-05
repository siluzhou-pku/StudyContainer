# 准备开始 

## 介绍
### 什么是Container？
Container是一个很小但是功能强大的依赖注入容器，它可以允许你解耦应用程序中的组件，以便编写干净和可测试的代码。

### 主要特点
- 互操作性：Container是 container-interop 项目的实现
- 速度：Container很小，相应的速度也很快
- Service Provider允许您封装代码和配置包，以便规律性复用
- Inflectors 允许您使用根据类型定义的容器来操作对象。
- Delegate containers 允许您在容器没有提供某种服务的时候，注册备份容器来解决。
- 可扩展性： Container工程都是模块化的，所以如果您需要做一些功能性的改变或者扩展，这都会很容易实现。
### 问题
Container由 Phil Bennett创建，在Twitter @philipobenito可以联系都他.

## 安装
### 系统要求：

为了使用 league/Container，要求PHP版本>=5.4.0, 推荐使用最新版本
### composer
Container已经发布在packagist上，可以使用composer安装
```
composer require league/container
```

现在大部分框架都包括Composer，您需要注意包含以下文件：
```
<?php

// include the Composer autoloader
require 'vendor/autoload.php';

```
### 单独行动
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

# 基本使用

## 准备开始
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


## 构造器注入
Container可以用于注册对象和注入构造器参数，例如依赖注入和配置参数
例如，如果我们有一个Session对象 依赖于StorageInterface的实现和一个会话密钥字符串，我们可以这么做：
```
?php

namespace Acme\Session;

class Session
{
    public $storage;

    public $sessionKey;

    public function __construct(StorageInterface $storage, $sessionKey)
    {
        $this->storage    = $storage;
        $this->sessionKey = $sessionKey;
    }
}
```

```
<?php

namespace Acme\Session;

interface StorageInterface
{
    // ..
}
```

```
<?php

namespace Acme\Session;

class Storage implements StorageInterface
{
    // ..
}

```

```
<?php

$container = new League\Container\Container;

// by registering the storage implementation as an alias of it's interface it
// is easy to swap out for other implementations
$container->add('Acme\Session\StorageInterface', 'Acme\Session\Storage');

$container
    ->add('Acme\Session\Session')
    ->withArgument('Acme\Session\StorageInterface')
    ->withArgument(new League\Container\Argument\RawArgument('my_super_secret_session_key'));

$session = $container->get('Acme\Session\Session');

var_dump($session instanceof Acme\Session\Session); // true
var_dump($session->storage instanceof Acme\Session\Storage); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true
```
##  设值方法注入
如果你相对构造注入，更喜欢设置方法注入的话，那么稍微改动几个步骤，即可完成。
```
<?php

namespace Acme\Session;

class Session
{
    public $storage;

    public $sessionKey;

    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }
}
```

```
<?php

namespace Acme\Session;

interface StorageInterface
{
    // ..
}
```
```
<?php

namespace Acme\Session;

class Storage implements StorageInterface
{
    // ..
}
```

```
<?php

$container = new League\Container\Container;

// by registering the storage implementation as an alias of it's interface it
// is easy to swap out for other implementations
$container->add('Acme\Session\StorageInterface', 'Acme\Session\Storage');

$container
    ->add('Acme\Session\Session')
    ->withMethodCall(
        'setStorage',
        [
            'Acme\Session\StorageInterface'
        ]
    )
    ->withMethodCall(
        'setSessionKey',
        [
            new League\Container\Argument\RawArgument('my_super_secret_session_key')
        ]
    );

$session = $container->get('Acme\Session\Session');

var_dump($session instanceof Acme\Session\Session); // true
var_dump($session->storage instanceof Acme\Session\Storage); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true

```
这种方法有一个额外的好处可以用可选设置操纵对象的行为，只有当实例需要的时候调用函数即可。




##  工厂闭包

最好的使用Container的方法是使用工厂闭包/匿名函数的方式来构建一个对象。通过注册闭包返回一个已配置的对象，只有当需要使用的时候，对象才会被加载。

例如，假设一个对象Foo依赖另一个对象Bar，下面的对象将会返回一个Foo类的实例，该实例包括一个Bar类的实例bar:
```
<?php

namespace Acme;

class Foo
{
    public $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
}
```
```
<?php

namespace Acme;

class Bar
{
    // ..
}
```

```
<?php

$container = new League\Container\Container;

$container->add('foo', function() {
    $bar = new Acme\Bar;
    return new Acme\Foo($bar);
});

$foo = $container->get('foo');

var_dump($foo instanceof Acme\Foo); // true
var_dump($foo->bar instanceof Acme\Bar); // true


```

# 高级功能
## 委派

委派是一种可以允许您注册一个或多个后台Container的方法，主要用于当这个container无法解决服务时，尝试解析服务。

一个委派器必须是container-interop的实现，并且可以用delegate方法注册。
```
<?php

namespace Acme\Container;

use Interop\Container\ContainerInterface;

class DelegateContainer implements ContainerInterface
{
    // ..
}

```


```
<?php

$container = new League\Container\Container;
$delegate  = new Acme\Container\DelegateContainer;

// this method can be invoked multiple times, each delegate
// is checked in the order that it was registered
$container->delegate($delegate);

```
现在一个委派就被注册了，如果一个服务无法完成，container将会调用委派的has和get方法来解决这个服务请求。

## 自动匹配
注意：自动匹配系统默认是关闭的，但是可以通过注册ReflectionContainer作用container的委派来打开这一设置。

Container可以自动通过检查构造器参数的类型提示自动解析对象和它的递归依赖项。不幸的是，这个方法有一些小的限制，但这些限制对小型的程序有利。首先，你必须使用构造器注入，其次，注入必须为对象。
```
<?php

namespace Acme;

class Foo
{
    public $bar;

    public $baz;

    public function __construct(Bar $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }
}

```
```
<?php

namespace Acme;

class Bar
{
    public $bam;

    public function __construct(Bam $bam)
    {
        $this->bam = $bam;
    }
}

```

```
<?php

namespace Acme;

class Baz
{
    // ..
}
```
```
<?php

namespace Acme;

class Bam
{
    // ..
}

```

在上述代码中，Foo有两个依赖项Bar和Baz。Bar又依赖于Bam.通常你需要这么做来返回Foo的实例：
```
<?php

$bam = new Acme\Bam;
$baz = new Acme\Baz;
$bar = new Acme\Bar($bam);
$foo = new Acme\Foo($bar, $baz);
```

在有嵌套的依赖项的前提下，这样子处理会让结果相当的笨重，而且很难跟踪。通过使用Container，返回一个完全配置好的Foo的实例就相当简单。
```
<?php

$container = new League\Container\Container;

// register the reflection container as a delegate to enable auto wiring
$container->delegate(
    new League\Container\ReflectionContainer
);

$foo = $container->get('Acme\Foo');

var_dump($foo instanceof Acme\Foo); // true
var_dump($foo->bar instanceof Acme\Bar); // true
var_dump($foo->baz instanceof Acme\Baz); // true
var_dump($foo->bar->bam instanceof Acme\Bam); // true
```


## 变形器 ？？
变形器允许您定义对某种特殊类型的对象在变为容器前的最后一项操作。

当您想要实现特定接口的对象上的某种方法时，这个非常有用。

想象下你有LoggerAwareInterface接口，想要继承这个接口实现一个叫做setLogger，每次检索到一个类的时候就传递一个记录。

```
$container->register('Some\Logger');
$container->register('Some\LoggerAwareClass'); // implements LoggerAwareInterface
$container->register('Some\Other\LoggerAwareClass'); // implements LoggerAwareInterface

$container->inflector('LoggerAwareInterface')
          ->invokeMethod('setLogger', ['Some\Logger']); // Some\Logger will be resolved via the container
```


这样子除了单独对每一个类增加一个方法调用，我们还可以简单的定义一个变形器，调用这种类型的类的方法。

## 服务提供器

服务提供器可以给您带来这些好处：可以组织您的容器的定义，从而得到更大的应用程序的性能提升。

为了创建服务提供器，只需要简单的扩展基本的服务提供器，并且定义想要注册的内容即可。

```
<?php

namespace Acme\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;

class SomeServiceProvider extends AbstractServiceProvider
{
    /**
     * The provides array is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @var array
     */
    protected $provides = [
        'key',
        'Some\Controller',
        'Some\Model',
        'Some\Request'
    ];

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        $this->getContainer()->add('key', 'value');
        
        $this->getContainer()->add('Some\Controller')
             ->withArgument('Some\Request')
             ->withArgument('Some\Model');

        $this->getContainer()->add('Some\Request');
        $this->getContainer()->add('Some\Model');
    }
}


```

为了注册这服务提供器，使得容器简单传递提供器的实例或者类的全称限定名到League\Container\Container::addServiceProvider 方法

```
<?php

$container = new League\Container\Container;

$container->addServiceProvider(new Acme\ServiceProvider\SomeServiceProvider);
$container->addServiceProvider('Acme\ServiceProvider\SomeServiceProvider');

```

这个注册方法只有当$provides 数组中一个别名被container请求的时候才会唤起，因此，当我们需要检索服务供应器提供的某一项目时，它一直到真正需要的时候才会注册，这提高了当你项目变大依赖增加时的性能。



## 启动服务供应器

如果功能上要求当服务供应器提供给container的时候就需要运行，例如，设置包括配置文件的变形器，我们可以让服务供应器自启动，通过继承
BootableServiceProviderInterface.

```
<?php

namespace Acme\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class SomeServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        // ...
    ];
    
    /**
     * In much the same way, this method has access to the container
     * itself and can interact with it however you wish, the difference
     * is that the boot method is invoked as soon as you register
     * the service provider with the container meaning that everything
     * in this method is eagerly loaded.
     *
     * If you wish to apply inflectors or register further service providers
     * from this one, it must be from a bootable service provider like
     * this one, otherwise they will be ignored.
     */
    public function boot()
    {
        $this->getContainer()
             ->inflector('SomeType')
             ->invokeMethod('someMethod', ['some_arg']);
            
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // ...
    }
}
```