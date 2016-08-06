<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:21
 */

require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;

//使用1
//用别名代替原名注册一个服务：APP\Service\SomeService别名为service
$container->add('service','App\Service\Service');

//现在可以直接检索别名来检索服务
//用get来获得实例，每get一次得到的是一个新的实例

$service1=$container->get('service');//出错原因：$service1不是对象，变成字符串了
$service2=$container->get('service');
echo "<br />Use 1:    ";
var_dump($service1 instanceof App\Service\Service); // true
var_dump($service1 === $service2); // false


//使用2
// 用完全限定类名来作为原型注册服务
$container->add('App\Service\Service');
//现在可以用类名来检索服务
//用get来获得实例，每get一次得到的是一个新的实例

$service3 = $container->get('App\Service\Service');
$service4 = $container->get('App\Service\Service');
echo "<br />Use 2:    ";
var_dump($service3 instanceof App\Service\Service); // true
var_dump($service3 === $service4); // false


//使用3


// 用全称限定类名用分享的方式注册服务
$container->share('App\Service\Service');

//获取服务的方法还是和之前一样使用Get,但是这样子得到的是同一个实例
$service5 = $container->get('App\Service\Service');
$service6 = $container->get('App\Service\Service');
echo "<br />Use 3:    ";
var_dump($service5 instanceof App\Service\Service); // true
var_dump($service5 === $service6); // true

//使用4
// 用别名给一个类的实例注册
$container->add('service', new App\Service\Service);

// 获取服务的方法还是和之前一样使用Get,但是这样子得到的是同一个实例
$service7 = $container->get('App\Service\Service');
$service8 = $container->get('App\Service\Service');
echo "<br />Use 4:    ";
var_dump($service7 instanceof App\Service\Service); // true
var_dump($service8 === $service2); // true
