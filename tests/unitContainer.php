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
//使用1
//用别名代替原名注册一个服务：Lulu\Service\SomeService别名为service
$container->add('service','\Lulu\Service\Service');

//现在可以直接检索别名来检索服务
//用get来获得实例，每get一次得到的是一个新的实例

$service1=$container->get('service');//出错原因：$service1不是对象，变成字符串了
$service2=$container->get('service');

var_dump($service1 instanceof Lulu\Service\Service); // true
var_dump($service1 === $service2); // false


//使用2
// 用完全限定类名来作为原型注册服务
$container->add('Lulu\Service\Service');
//现在可以用类名来检索服务
//用get来获得实例，每get一次得到的是一个新的实例

$service3 = $container->get('Lulu\Service\Service');
$service4 = $container->get('Lulu\Service\Service');
echo "<br />";
var_dump($service3 instanceof Lulu\Service\Service); // true
var_dump($service3 === $service4); // false


//使用3


// 用全称限定类名用分享的方式注册服务
$container->share('Lulu\Service\Service');

//获取服务的方法还是和之前一样使用Get,但是这样子得到的是同一个实例
$service1 = $container->get('Lulu\Service\Service');
$service2 = $container->get('Lulu\Service\Service');
echo "<br />";
var_dump($service1 instanceof Lulu\Service\Service); // true
var_dump($service1 === $service2); // true

//使用4
// register the service as an instance against an alias
$container->add('service', new Acme\Service\SomeService);

// you retrieve the service in exactly the same way, however, each time you
// call `get` you will retrieve the same instance
$service1 = $container->get('Acme\Service\SomeService');
$service2 = $container->get('Acme\Service\SomeService');

var_dump($service1 instanceof Acme\Service\SomeService); // true
var_dump($service1 === $service2); // true