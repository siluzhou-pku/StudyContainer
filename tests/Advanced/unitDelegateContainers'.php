<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:57
 */


require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;

//测试委派
$delegate  = new App\Container\DelegateContainer;

// 这个方法可以使用措辞，每个委派都会按照注册的顺序检查
$container->delegate($delegate);


