<?php

/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:35
 */
namespace  App\Session;
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