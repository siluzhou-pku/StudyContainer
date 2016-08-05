<?php
/**
 * Created by PhpStorm.
 * User: Zhousilu
 * Date: 2016/8/3
 * Time: 11:02
 */
require '../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;
////使用1
////用别名代替原名注册一个服务：Lulu\Service\SomeService别名为service
//$container->add('service','\Lulu\Service\Service');
//
////现在可以直接检索别名来检索服务
////用get来获得实例，每get一次得到的是一个新的实例
//
//$service1=$container->get('service');//出错原因：$service1不是对象，变成字符串了
//$service2=$container->get('service');
//
//var_dump($service1 instanceof Lulu\Service\Service); // true
//var_dump($service1 === $service2); // false
//
//
////使用2
//// 用完全限定类名来作为原型注册服务
//$container->add('Lulu\Service\Service');
////现在可以用类名来检索服务
////用get来获得实例，每get一次得到的是一个新的实例
//
//$service3 = $container->get('Lulu\Service\Service');
//$service4 = $container->get('Lulu\Service\Service');
//echo "<br />";
//var_dump($service3 instanceof Lulu\Service\Service); // true
//var_dump($service3 === $service4); // false
//
//
////使用3
//
//
//// 用全称限定类名用分享的方式注册服务
//$container->share('Lulu\Service\Service');
//
////获取服务的方法还是和之前一样使用Get,但是这样子得到的是同一个实例
//$service1 = $container->get('Lulu\Service\Service');
//$service2 = $container->get('Lulu\Service\Service');
//echo "<br />";
//var_dump($service1 instanceof Lulu\Service\Service); // true
//var_dump($service1 === $service2); // true
//
////使用4
//// 用别名给一个类的实例注册
//$container->add('service', new Lulu\Service\Service);
//
//// 获取服务的方法还是和之前一样使用Get,但是这样子得到的是同一个实例
//$service1 = $container->get('Lulu\Service\Service');
//$service2 = $container->get('Lulu\Service\Service');
//echo "<br />";
//var_dump($service1 instanceof Lulu\Service\Service); // true
//var_dump($service1 === $service2); // true


$u=new Lulu\Session\Session();
$v=new Lulu\Session\User();
var_dump($v);
exit;


// 用接口实现作为接口的别名，可以便于和其他的接口实现交互
$container->add('Lulu\Session\StorageInterface', 'Lulu\Session\Storage');

$container
    ->add('Lulu\Session\Session')
    ->withArgument('Lulu\Session\StorageInterface')
    ->withArgument(new League\Container\Argument\RawArgument('my_super_secret_session_key'));

$session = $container->get('Lulu\Session\Session');

var_dump($session instanceof Lulu\Session\Session); // true
var_dump($session->storage instanceof Lulu\Session\Storage); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true
exit;


//测试用设值方式注入 报错


/*
$container->add('Lulu\Session\StorageInterface2', 'Lulu\Session\Storage2');

$container
    ->add('Lulu\Session\Session2')
    ->withMethodCall(
        'setStorage',
        [
            'Lulu\Session\StorageInterface2'
        ]
    )
    ->withMethodCall(
        'setSessionKey',
        [
            new League\Container\Argument\RawArgument('my_super_secret_session_key')
        ]
    );

$session = $container->get('Lulu\Session\Session2');
echo "<br />";
var_dump($session instanceof Lulu\Session\Session2); // true
var_dump($session->storage instanceof Lulu\Session\Storage2); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true
*/


//测试用闭包注入

$container->add('foo', function() {
    $bar = new Lulu\Bar;
    return new Lulu\Foo($bar);
});

$foo = $container->get('foo');

echo "<br />Factory Closure:    ";
var_dump($foo instanceof Lulu\Foo); // true
var_dump($foo->bar instanceof Lulu\Bar); // true

/*//测试委派
$delegate  = new Lulu\Container\DelegateContainer;

// 这个方法可以使用措辞，每个委派都会按照注册的顺序检查
$container->delegate($delegate);
*/


//测试自动匹配
// 把反射容器注册为一个委派来实现自动匹配。
$container->delegate(
    new League\Container\ReflectionContainer
);

$foo = $container->get('Lulu\Foo2');
echo "<br />Auto Writing:  ";
var_dump($foo instanceof Lulu\Foo2); // true
var_dump($foo->bar instanceof Lulu\Bar2); // true
var_dump($foo->baz instanceof Lulu\Baz); // true
var_dump($foo->bar->bam instanceof Lulu\Bam); // true


//测试service provider
$container->addServiceProvider(new Lulu\ServiceProvider\SomeServiceProvider);
$container->addServiceProvider('Lulu\ServiceProvider\SomeServiceProvider');