<?php
/**
 * Created by PhpStorm.
 * User: Zhousilu
 * Date: 2016/8/4
 * Time: 14:10
 */

namespace Lulu\Session;

class Session2
{
    public $storage;

    public $sessionKey;

    public function setStorage(StorageInterface2 $storage)
    {
        $this->storage = $storage;
    }

    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }
}

interface StorageInterface2
{
    // ..
}


class Storage2 implements StorageInterface2
{
    // ..
}



