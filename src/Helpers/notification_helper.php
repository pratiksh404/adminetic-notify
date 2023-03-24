<?php

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Adminetic\Notify\Services\SystemNotification;
use Adminetic\Notify\Events\PushNotificationEvent;
use Adminetic\Notify\Events\GeneralPushNotificationEvent;


// Notification Setting


if (!function_exists('general_notification_mediums')) {
    function general_notification_mediums($default = null)
    {
        return config('adminetic_notification.general_notification_mediums', $default ?? array('database'));
    }
}

if (!function_exists('notify')) {
    function notify($notification_group_name, $notification_setting_name, $data, $audiance = null)
    {
        $system_notification = new SystemNotification($notification_group_name, $notification_setting_name, $audiance);
        if ($system_notification->active) {
            $notify_data = $system_notification->fetchData($data);
            try {
                Notification::send($system_notification->audiance(), new \Adminetic\Notify\GeneralNotification($notify_data));
                event(new GeneralPushNotificationEvent($notify_data));
            } catch (\Throwable $th) {
                Log::debug($th);
            }
        }
    }
}

if (!function_exists('generalNotify')) {
    function generalNotify($data, $audience_users = null)
    {
        $users = $audience_users ?? adminNotificationUsers();
        try {
            Notification::send($users, new \Adminetic\Notify\GeneralNotification($data));
            event(new GeneralPushNotificationEvent($data));
        } catch (\Throwable $th) {
            Log::debug($th);
            throw $th;
        }
    }
}

if (!function_exists('adminNotify')) {
    function adminNotify($data, $audience_users = null)
    {
        $users = !is_null($audience_users) ? $audience_users : adminNotificationUsers();
        generalNotify($data, $users);
    }
}

if (!function_exists('adminNotificationUsers')) {
    function adminNotificationUsers()
    {
        $admin_notification_by_role = config('adminetic_notification.admin_notification_by_role', ['superadmin', 'admin']);
        $users = User::whereHas('roles', function ($roles) use ($admin_notification_by_role) {
            return $roles->whereIn('name', $admin_notification_by_role);
        })->get();
        return $users;
    }
}

if (!function_exists('pushNotify')) {
    function pushNotify($message)
    {
        event(new PushNotificationEvent($message));
    }
}

if (!function_exists('severityColor')) {
    function severityColor($severity)
    {
        return $severity <= 4 && $severity >= 0
            ? [
                0 => 'primary',
                1 => 'secondary',
                2 => 'warning',
                3 => 'danger',
                4 => 'danger',
            ][$severity]
            : 'primary';
    }
}

if (!function_exists('severity')) {
    function severity($severity)
    {
        return $severity <= 4 && $severity >= 0
            ? [
                0 => 'Insignificant',
                1 => 'Low',
                2 => 'Mid',
                3 => 'High',
                4 => 'Very High',
            ][$severity]
            : 'Not Defined';
    }
}
