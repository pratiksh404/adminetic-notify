<?php

use Adminetic\Notify\Events\GeneralPushNotificationEvent;
use Adminetic\Notify\Events\PushNotificationEvent;
use Adminetic\Notify\Notifications\GeneralNotification;
use Adminetic\Notify\Services\SystemNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

if (! function_exists('is_pusher_set')) {
    function is_pusher_set($notify_data = null)
    {
        return env('PUSHER_APP_ID') !== null && env('PUSHER_APP_KEY') !== null && env('PUSHER_APP_SECRET') !== null && env('PUSHER_APP_CLUSTER') !== null && (isset($notify_data['channels']) ? in_array('pusher', $notify_data['channels']) : true) && ! config('notify.polling', false);
    }
}
// Notification Setting
if (! function_exists('general_notification_mediums')) {
    function general_notification_mediums($default = null)
    {
        return config('notify.general_notification_mediums', $default ?? ['database']);
    }
}

if (! function_exists('notify')) {
    function notify($notification_setting_name, $data, $audience = null)
    {
        $system_notification = new SystemNotification($notification_setting_name, $audience);
        if ($system_notification->active) {
            $notify_data = $system_notification->fetchData($data);
            try {
                Notification::send($system_notification->audience(), new GeneralNotification($notify_data));
                if (is_pusher_set($notify_data)) {
                    event(new GeneralPushNotificationEvent($notify_data));
                }

                return true;
            } catch (\Throwable $th) {
                Log::debug($th);
            }
        }
    }
}

if (! function_exists('generalNotify')) {
    function generalNotify($data, $audience_users = null)
    {
        notify('general', ! is_array($data) ? [
            'title' => 'General Notification',
            'message' => $data,
        ] : $data, $audience_users);
    }
}

if (! function_exists('adminNotify')) {
    function adminNotify($data, $audience_users = null)
    {
        $users = ! is_null($audience_users) ? $audience_users : adminNotificationUsers();
        generalNotify($data, $users);
    }
}

if (! function_exists('adminNotificationUsers')) {
    function adminNotificationUsers()
    {
        $admin_notification_by_role = config('notify.admin_notification_by_role', ['superadmin', 'admin']);
        $users = User::whereHas('roles', function ($roles) use ($admin_notification_by_role) {
            return $roles->whereIn('name', $admin_notification_by_role);
        })->get();

        return $users;
    }
}

if (! function_exists('pushNotify')) {
    function pushNotify($message)
    {
        if (is_pusher_set()) {
            event(new PushNotificationEvent($message));
        }
    }
}

if (! function_exists('severityColor')) {
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

if (! function_exists('severity')) {
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
