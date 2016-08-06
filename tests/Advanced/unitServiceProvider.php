<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 11:13
 */


require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;



//测试service provider
$container->addServiceProvider(new App\ServiceProvider\SomeServiceProvider);
$container->addServiceProvider('App\ServiceProvider\SomeServiceProvider');