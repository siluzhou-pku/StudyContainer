<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 11:00
 */

namespace App\Foo2;


class Bar
{
    public $bam;

    public function __construct(Bam $bam)
    {
        $this->bam = $bam;
    }

}