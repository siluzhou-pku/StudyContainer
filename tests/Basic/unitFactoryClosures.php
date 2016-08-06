<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:52
 */
require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;

//测试用闭包注入

$container->add('foo', function() {
    $bar = new App\Foo\Bar;
    return new App\Foo\Foo($bar);
});

$foo = $container->get('foo');

echo "Factory Closure:    ";
var_dump($foo instanceof App\Foo\Foo); // true
var_dump($foo->bar instanceof App\Foo\Bar); // true