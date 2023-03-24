<?php

namespace Adminetic\Notify\Http\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\Admin\Role;
use App\Models\Admin\Setting;

class NotificationSetting extends Component
{

    public $roles;

    public $settings;
    public $active_group;
    public $active_setting_name;
    public $active_setting;

    // Setting Values
    public $icon;
    public $active;
    public $default_severity;
    public $default_type;
    public $default_title;
    public $audiance = [];
    public $channels = [];

    // Notification Display Setting
    public  $allow_dismiss =  true;
    public  $newest_on_top =  true;
    public  $mouse_over =  false;
    public  $showProgressbar =  false;
    public  $spacing =  10;
    public  $timer =  8000;
    public  $placement_from =  'bottom';
    public  $placement_align =  'right';
    public  $delay =  1000;
    public  $animate_enter =  'bounceIn';
    public  $animate_exit =  'rubberBand';

    public $show_audiance = false;

    protected $listeners = ['initializeNotificationSetting' => 'initialize_notification_setting'];

    public function mount()
    {
        $this->roles = Role::orderBy('level', 'desc')->with('users', 'users.student.classroom', 'users.student.section', 'users.student.route')->get();
        $settings  = Setting::where('setting_name', 'Notification')->first()->setting_custom;
        $this->settings = $settings;
        $this->active_group = array_key_first($settings);
        $this->active_setting_name = array_key_first($settings[$this->active_group]);
        $this->active_setting = $settings[$this->active_group][$this->active_setting_name];
        $this->setActiveSettingValues();
    }

    public function showAudiance()
    {
        $this->show_audiance = true;
    }

    public function select_setting($group, $active_setting_name)
    {
        $this->active_group = $group;
        $this->active_setting_name = $active_setting_name ?? 0;
        $this->active_setting = $this->settings[$group][$active_setting_name];
        $this->setActiveSettingValues();
        $this->show_audiance = false;
    }

    public function save()
    {
        $setting = Setting::where('setting_name', 'Notification')->first();
        $setting_custom = $setting->setting_custom;
        if (!is_null($setting)) {
            $active_setting = $this->active_setting;
            $configuration = [
                'name' => $active_setting['name'],
                'default_title' => $this->default_title ?? $active_setting['default_title'],
                'active' => $this->active  ?? $active_setting['active'],
                'default_severity' => $this->default_severity  ?? $active_setting['default_severity'],
                'default_type' => $this->default_type  ?? $active_setting['default_type'],
                'audiance' => $this->audiance  ?? $active_setting['audiance'],
                'channels' => $this->channels  ?? $active_setting['channels'],
                'icon' => $this->icon  ?? $active_setting['icon'] ?? 'fa fa-bell',

                'allow_dismiss' =>  $this->newest_on_top ?? $active_setting['allow_dismiss'] ?? true,
                'newest_on_top' =>  $this->newest_on_top ?? $active_setting['newest_on_top'] ?? true,
                'mouse_over' => $this->mouse_over ?? $active_setting['mouse_over'] ?? false,
                'showProgressbar' =>  $this->showProgressbar ?? $active_setting['showProgressbar'] ?? false,
                'spacing' => $this->spacing ??  $active_setting['spacing'] ?? 10,
                'timer' =>  $this->timer ?? $active_setting['timer'] ?? 8000,
                'placement_from' =>  $this->placement_from ?? $active_setting['placement_from'] ?? 'bottom',
                'placement_align' =>  $this->placement_align ?? $active_setting['placement_align'] ?? 'right',
                'delay' => $this->delay ??  $active_setting['delay'] ?? 1000,
                'animate_enter' => $this->animate_enter ??  $active_setting['animate_enter'] ?? 'bounceIn',
                'animate_exit' => $this->animate_exit ??  $active_setting['animate_exit'] ?? 'rubberBand',
            ];
            $setting_custom[$this->active_group][$this->active_setting_name] = $configuration;
            $setting->update([
                'setting_custom' => $setting_custom
            ]);

            $this->emit('notification_setting_updated');
        }
    }

    public function initialize_notification_setting()
    {
        $this->emit('initialize_notification_setting');
    }

    public function render()
    {
        return view('notifiy::livewire.admin.notify.notification-setting');
    }

    private function setActiveSettingValues()
    {
        $active_setting = $this->active_setting;
        if (!is_null($active_setting)) {
            $this->default_title = $active_setting['default_title'] ?? null;
            $this->active = $active_setting['active'] ?? null;
            $this->default_severity = $active_setting['default_severity'] ?? null;
            $this->default_type = $active_setting['default_type'] ?? null;
            $this->audiance = $active_setting['audiance'] ?? null;
            $this->channels = $active_setting['channels'] ?? null;

            // Notification Display Setting
            $this->allow_dismiss =  $active_setting['allow_dismiss'] ?? true;
            $this->newest_on_top =  $active_setting['newest_on_top'] ?? true;
            $this->mouse_over =  $active_setting['mouse_over'] ?? false;
            $this->showProgressbar =  $active_setting['showProgressbar'] ?? false;
            $this->spacing =  $active_setting['spacing'] ?? 10;
            $this->timer =  $active_setting['timer'] ?? 8000;
            $this->placement_from =  $active_setting['placement_from'] ?? 'bottom';
            $this->placement_align =  $active_setting['placement_align'] ?? 'right';
            $this->delay = $active_setting['delay'] ?? 1000;
            $this->animate_enter =  $active_setting['animate_enter'] ?? 'bounceIn';
            $this->animate_exit =  $active_setting['animate_exit'] ?? 'rubberBand';
        }
    }
}
