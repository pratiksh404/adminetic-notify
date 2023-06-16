<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    */
    'available_notification_medium_in_system' => ['database', 'mail'],

    /*
    | OPTIONS:
    | 'database','mail'
    */
    'general_notification_mediums' => ['database', 'mail'],

    /*
    |--------------------------------------------------------------------------
    | Default Admin Notification By Role
    |--------------------------------------------------------------------------
    */
    'admin_notification_by_role' => ['superadmin', 'admin'],

    /*
    |--------------------------------------------------------------------------
    | Polling Configuration
    |--------------------------------------------------------------------------
    | Note pusher will be turned off if polling is turned on
    */
    'polling' => true,
    'polling_intervals' => 10000,
];
