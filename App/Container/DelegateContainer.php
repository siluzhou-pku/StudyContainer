<?php

/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 10:57
 */
namespace App\Container;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;

class DelegateContainer  implements ContainerInterface
{


    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }
}