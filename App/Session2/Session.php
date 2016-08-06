<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:40
 */

namespace App\Session2;


class Session
{
    public $storage;

    public $sessionKey;

    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

}