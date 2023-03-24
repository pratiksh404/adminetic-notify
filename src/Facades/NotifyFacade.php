<?php

namespace Adminetic\Notify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Adminetic\Notification\Skeleton\SkeletonClass
 */
class NotifyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notification';
    }
}
