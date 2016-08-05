<?php

/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/5
 * Time: 11:31
 */
namespace Lulu;
class Foo
{
    public $bar;
    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

}





class Foo2
{
    public $bar;

    public $baz;

    public function __construct(Bar2 $bar, Baz $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }
}

