<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/3
 * Time: 21:51
 */
namespace Lulu\Session;

class Session
{
    public $storage;

    public $sessionKey;

    public function __construct(StorageInterface $storage, $sessionKey)
    {
        $this->storage    = $storage;
        $this->sessionKey = $sessionKey;
    }
}

interface StorageInterface
{

}

class storage implements  StorageInterface
{

}