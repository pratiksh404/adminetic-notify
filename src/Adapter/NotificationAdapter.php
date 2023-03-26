<?php

namespace Adminetic\Notify\Adapter;

use Pratiksh\Adminetic\Contracts\PluginInterface;
use Pratiksh\Adminetic\Traits\SidebarHelper;

class NotificationAdapter implements PluginInterface
{
    use SidebarHelper;

    public function assets(): array
    {
        return  [];
    }

    public function myMenu(): array
    {
        return  [
            [
                'type' => 'breaker',
                'name' => 'Notification',
                'description' => 'Modules',
            ],
            [
                'type' => 'link',
                'name' => 'My Notifiction',
                'icon' => 'fa fa-bell',
                'is_active' => request()->routeIs('my_notification') ? 'active' : '',
                'link' => route('my_notification'),
            ],
            [
                'type' => 'link',
                'name' => 'Notification Setting',
                'icon' => 'fa fa-terminal',
                'is_active' => request()->routeIs('my_notification') ? 'active' : '',
                'link' => route('notification_setting'),
            ],
        ];
    }
}
