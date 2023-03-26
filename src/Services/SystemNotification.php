<?php

namespace Adminetic\Notify\Services;

use App\Models\User;
use Pratiksh\Adminetic\Models\Admin\Setting;
use Adminetic\Notify\Notifications\GeneralNotification;

class SystemNotification
{
    public $notification_setting_name;
    public $notification_group_name;
    public $notification_setting;
    public $audience;
    public $setting;
    public $active = true;
    public $data;

    public function __construct($notification_setting_name, $audience = null)
    {
        $notify = Setting::firstOrCreate(
            ['setting_name' => 'Notification', 'setting_group' => 'Notification', 'setting_type' => 11],
        );
        $this->audience = $audience;
        $notification_setting_name = $notification_setting_name;
        $this->setting = $notify->setting_custom;
        $this->setNotificationSetting($notify, $notification_setting_name);
        $this->active = $this->notification_setting['active'] ?? true;
    }

    private function setNotificationSetting($notify, $notification_setting_name)
    {
        $display_name = $notification_setting_name;
        $notification_setting_name = strtolower(str_replace([' ', '-', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '//', '`', '~'], '_', $notification_setting_name));
        if (isset($this->setting[$notification_setting_name])) {
            $this->notification_setting = $this->setting[$notification_setting_name] ?? null;
        } else {
            $setting_custom = $notify->setting_custom;
            $admin_users = adminNotificationUsers()->pluck('id')->toArray();
            $setting_custom[$notification_setting_name] = [
                'name' => $display_name,
                'group' => "System",
                'active' => true,
                'default_severity' => GeneralNotification::HIGH,
                'default_type' => GeneralNotification::NEWS,
                'default_title' => 'General',
                'category' => 'Info',
                'audience' => $admin_users,
                'channels' => config('notify.available_notification_medium_in_system', ['database', 'mail']),
                'allow_dismiss' => true,
                'newest_on_top' => true,
                'mouse_over' => false,
                'showProgressbar' => false,
                'spacing' => 10,
                'timer' => 8000,
                'placement_from' => 'bottom',
                'placement_align' => 'right',
                'delay' => 1000,
                'animate_enter' => 'bounceIn',
                'animate_exit' => 'rubberBand',
            ];
            $notify->update([
                'setting_custom' => $setting_custom
            ]);
            $this->setting = $notify->setting_custom;
            $this->notification_setting = $this->setting[$notification_setting_name] ?? null;
            $this->notification_group_name = $this->setting['group'] ?? 'System';
        }
    }

    public function fetchData(array $data)
    {
        $default_setting = $this->notification_setting;
        $data =  [
            'title' => $data['title'] ?? $default_setting['default_title'],
            'message' => $data['message'] ?? null,
            'subject' => $data['subject'] ?? null,
            'action' => $data['action'] ?? $default_setting['default_action'] ?? null,
            'color' => $data['color'] ?? $default_setting['default_color'] ?? severityColor($data['color'] ?? $default_setting['default_severity']),
            'type' => $data['type'] ?? $default_setting['default_type'],
            'severity' => $data['severity'] ?? $default_setting['default_severity'],
            'icon' => $data['icon'] ?? $default_setting['default_icon'] ?? 'fa fa-bell',
            'channels' => $data['channels'] ?? $default_setting['channels'] ?? ['database'],
            'audience' => $this->audience ?? $data['audience'] ?? $default_setting['audience'] ?? null,
            'from' => 1,
            'category' => $this->notification_group_name,
            'allow_dismiss' => $data['allow_dismiss'] ?? $default_setting['allow_dismiss'] ?? true,
            'newest_on_top' => $data['newest_on_top'] ?? $default_setting['newest_on_top'] ?? true,
            'mouse_over' => $data['mouse_over'] ?? $default_setting['mouse_over'] ?? false,
            'showProgressbar' => $data['showProgressbar'] ?? $default_setting['showProgressbar'] ?? false,
            'spacing' => $data['spacing'] ?? $default_setting['spacing'] ?? 10,
            'timer' => $data['timer'] ?? $default_setting['timer'] ?? 8000,
            'placement_from' => $data['placement_from'] ?? $default_setting['placement_from'] ?? 'bottom',
            'placement_align' => $data['placement_align'] ?? $default_setting['placement_align'] ?? 'right',
            'delay' => $data['delay'] ?? $default_setting['delay'] ?? 1000,
            'animate_enter' => $data['animate_enter'] ?? $default_setting['animate_enter'] ?? 'bounceIn',
            'animate_exit' => $data['animate_exit'] ?? $default_setting['animate_exit'] ?? 'rubberBand',
        ];

        $this->data = $data;

        return $data;
    }

    public function audience()
    {
        return User::find($this->data['audience'] ?? []);
    }
}
