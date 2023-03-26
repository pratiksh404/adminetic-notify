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
    'general_notification_mediums' => ['database'],

    /*
    |--------------------------------------------------------------------------
    | Default Admin Notification By Role
    |--------------------------------------------------------------------------
    */
    'admin_notification_by_role' => ['superadmin', 'admin'],
];
