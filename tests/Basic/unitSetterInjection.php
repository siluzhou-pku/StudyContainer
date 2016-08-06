<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:41
 */

require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;

//测试用设值方式注入 报错



$container->add('App\Session2\StorageInterface', 'App\Session2\Storage');

$container
    ->add('App\Session2\Session')
    ->withMethodCall(
        'setStorage',
        [
            'App\Session2\StorageInterface'
        ]
    )
    ->withMethodCall(
        'setSessionKey',
        [
            new League\Container\Argument\RawArgument('my_super_secret_session_key')
        ]
    );

$session = $container->get('App\Session2\Session');
echo "Setter Injection :  ";
var_dump($session instanceof App\Session2\Session); // true
var_dump($session->storage instanceof App\Session2\Storage); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true
