<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/5
 * Time: 11:32
 */

namespace Lulu;


class Bar
{

}



class Bar2
{
    public $bam;

    public function __construct(Bam $bam)
    {
        $this->bam = $bam;
    }
}

class Baz
{
    // ..
}
class Bam
{
    // ..
}