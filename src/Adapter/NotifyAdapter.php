<?php

namespace Adminetic\Notify\Adapter;

use Pratiksh\Adminetic\Contracts\PluginInterface;
use Pratiksh\Adminetic\Traits\SidebarHelper;

class NotifyAdapter implements PluginInterface
{
    use SidebarHelper;

    public function assets(): array
    {
        return  [
            [
                'name' => 'Notifications',
                'active' => true,
                'files' => [
                    // Notify JS
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/notify/bootstrap-notify.min.js',
                    ],
                    // One Signal SDK
                    [
                        'type' => 'js',
                        'active' => true,
                        'link' => 'https://cdn.onesignal.com/sdks/OneSignalSDK.js',
                    ],
                    // Pusher SDK
                    [
                        'type' => 'js',
                        'active' => true,
                        'link' => 'https://js.pusher.com/7.2/pusher.min.js',
                    ],
                ],
            ],
            [
                'name' => 'IconPicker',
                'active' => true,
                'files' => [
                    [
                        'type' => 'css',
                        'active' => true,
                        'location' => 'adminetic/assets/js/icon-picker/iconpicker-1.5.0.css',
                    ],
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/icon-picker/iconpicker-1.5.0.js',
                    ],
                ],
            ],
        ];
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
