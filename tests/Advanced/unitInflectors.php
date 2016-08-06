<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 11:03
 */

require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;

$container->register('Some\Logger');
$container->register('Some\LoggerAwareClass'); // implements LoggerAwareInterface
$container->register('Some\Other\LoggerAwareClass'); // implements LoggerAwareInterface

$container->inflector('LoggerAwareInterface')
    ->invokeMethod('setLogger', ['Some\Logger']); // Some\Logger will be resolved via the container