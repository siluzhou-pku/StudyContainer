<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 11:00
 */

namespace App\Foo2;


class Foo
{
    public $bar;

    public $baz;

    public function __construct(Bar $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }

}