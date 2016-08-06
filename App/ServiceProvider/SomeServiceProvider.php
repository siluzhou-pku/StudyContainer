<?php
/**
 * Created by PhpStorm.
 * User: lulu
 * Date: 2016/8/6
 * Time: 11:12
 */

namespace App\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
class SomeServiceProvider extends AbstractServiceProvider
{

    /**
     * The provides array is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @var array
     */
    protected $provides = [
        'key',
        'Some\Controller',
        'Some\Model',
        'Some\Request'
    ];

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        $this->getContainer()->add('key', 'value');

        $this->getContainer()->add('Some\Controller')
            ->withArgument('Some\Request')
            ->withArgument('Some\Model');

        $this->getContainer()->add('Some\Request');
        $this->getContainer()->add('Some\Model');
    }
}