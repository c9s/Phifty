<?php
namespace Phifty\ServiceProvider;

abstract class BaseServiceProvider
{
    public $options;

    abstract public function getId();

    /**
     * register service
     *
     * XXX: we should set options in constructor
     */
    abstract public function register($kernel, $options = array());
}
