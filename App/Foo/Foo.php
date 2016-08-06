<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:53
 */

namespace App\Foo;


class Foo
{
    public $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
}