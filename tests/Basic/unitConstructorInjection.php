<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:33
 */

require '../../vendor/autoload.php';
//实例化一个container对象


$container=new League\Container\Container;


// 用接口实现作为接口的别名，可以便于和其他的接口实现交互
$container->add('App\Session\StorageInterface', 'App\Session\Storage');

$container
    ->add('App\Session\Session')
    ->withArgument('App\Session\StorageInterface')
    ->withArgument(new League\Container\Argument\RawArgument('my_super_secret_session_key'));

$session = $container->get('App\Session\Session');
echo "Construvt Injection :";
var_dump($session instanceof App\Session\Session); // true
var_dump($session->storage instanceof App\Session\Storage); // true
var_dump($session->sessionKey === 'my_super_secret_session_key'); // true
exit;