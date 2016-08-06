<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:59
 */


require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;


//测试自动匹配
// 把反射容器注册为一个委派来实现自动匹配。
$container->delegate(
    new League\Container\ReflectionContainer
);

$foo = $container->get('App\Foo2\Foo');
echo "Auto Writing:  ";
var_dump($foo instanceof App\Foo2\Foo); // true
var_dump($foo->bar instanceof App\Foo2\Bar); // true
var_dump($foo->baz instanceof App\Foo2\Baz); // true
var_dump($foo->bar->bam instanceof App\Foo2\Bam); // true