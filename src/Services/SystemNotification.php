<?php

namespace Adminetic\Notify\Services;

use App\Models\User;
use App\Models\Admin\Setting;

class SystemNotification
{
    public $notification_group_name;
    public $notification_setting_name;
    public $notification_setting;
    public $audiance;
    public $setting;
    public $active = true;
    public $data;

    public function __construct($notification_group_name, $notification_setting_name, $audiance = null)
    {
        $this->audiance = $audiance;
        $this->notification_group_name = $notification_group_name;
        $this->notification_setting_name = $notification_setting_name;
        $this->setting = Setting::firstOrCreate(
            ['setting_name' => 'Notification', 'setting_group' => 'Notification', 'setting_type' => 11],
        )->setting_custom;
        $this->notification_setting = $this->setting[$notification_group_name][$notification_setting_name] ?? null;
        $this->active = $this->notification_setting['active'] ?? true;
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
            'audiance' => $this->audiance ?? $data['audiance'] ?? $default_setting['audiance'] ?? null,
            'from' => 1,
            'category' => $this->notification_group_name
        ];

        $this->data = $data;

        return $data;
    }

    public function audiance()
    {
        return User::find($this->data['audiance'] ?? []);
    }
}
