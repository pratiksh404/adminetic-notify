<?php

namespace Adminetic\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class GeneralNotification extends Notification
{
    // use Queueable;

    // Constants

    // Actions
    const BROWSE = 'Browse';
    const READ = 'Read';
    const EDIT = 'Edit';
    const ADD = 'Add';
    const DELETE = 'Delete';

    // Severity
    const INSIGNIFICANT = 0;
    const LOW = 1;
    const MID = 2;
    const HIGH = 3;
    const VERYHIGH = 4;

    // From
    const FROM_SYSTEM = 1;
    const FROM_USER = 2;

    // Type
    const INFO = 1;
    const ALERT = 2;
    const REMINDER = 3;
    const MESSAGE = 4;
    const WARNING = 5;
    const NEWS = 6;
    const REPORT = 7;

    public $title;

    public $message;

    public $action;

    public $url;

    public $subject;

    public $color;

    public $type;

    public $group;

    public $severity;

    public $from;

    public $icon = 'fa fa-bell';

    public $is_snoozed = false;

    public $alarm = null;

    public $body;

    public $channels;

    public $audience;

    // Notification Display Setting
    public $allow_dismiss = true;
    public $newest_on_top = true;
    public $mouse_over = false;
    public $showProgressbar = false;
    public $spacing = 10;
    public $timer = 8000;
    public $placement_from = 'bottom';
    public $placement_align = 'right';
    public $delay = 1000;
    public $animate_enter = 'bounceIn';
    public $animate_exit = 'rubberBand';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->title = $data['title'] ?? 'System Notification';
        $this->message = $data['message'] ?? 'Message not found.';
        $this->action = $data['action'] ?? null;
        $this->color = $data['color'] ?? 'primary';
        $this->url = $data['url'] ?? null;
        $this->group = $data['group'] ?? 'General';
        $this->type = $data['type'] ?? 1;
        $this->severity = $data['severity'] ?? 1;
        $this->from = $data['from'] ?? 1;
        $this->icon = $data['icon'] ?? 'fa fa-bell';
        $this->is_snoozed = $data['is_snoozed'] ?? false;
        $this->alarm = $data['alarm'] ?? null;
        $this->channels = $data['channels'] ?? null;
        $this->audience = $data['audience'] ?? null;

        // Notification Display Setting
        $this->allow_dismiss = $data['allow_dismiss'] ?? true;
        $this->newest_on_top = $data['newest_on_top'] ?? true;
        $this->mouse_over = $data['mouse_over'] ?? false;
        $this->showProgressbar = $data['showProgressbar'] ?? false;
        $this->spacing = $data['spacing'] ?? 10;
        $this->timer = $data['timer'] ?? 8000;
        $this->placement_from = $data['placement_from'] ?? 'bottom';
        $this->placement_align = $data['placement_align'] ?? 'right';
        $this->delay = $data['delay'] ?? 1000;
        $this->animate_enter = $data['animate_enter'] ?? 'bounceIn';
        $this->animate_exit = $data['animate_exit'] ?? 'rubberBand';

        $this->subject = $data['subject'] ?? (($this->action ?? 'General').' Notification : '.$this->title);

        $body = [
            'title' => $this->title,
            'message' => $this->message,
            'action' => $this->action,
            'color' => $this->color,
            'url' => $this->url,
            'group' => $this->group,
            'icon' => $this->icon,
            'severity' => $this->severity,
            'from' => $this->from,
            'is_snoozed' => $this->is_snoozed,
            'alarm' => $this->alarm,
            'channels' => $this->channels,
            'audience' => $this->audience,
            'allow_dismiss' => $this->allow_dismiss,
            'newest_on_top' => $this->newest_on_top,
            'mouse_over' => $this->mouse_over,
            'showProgressbar' => $this->showProgressbar,
            'spacing' => $this->spacing,
            'timer' => $this->timer,
            'placement_from' => $this->placement_from,
            'placement_align' => $this->placement_align,
            'delay' => $this->delay,
            'animate_enter' => $this->animate_enter,
            'animate_exit' => $this->animate_exit,
            'subject' => $this->subject,
        ];
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return Arr::where($this->body['channels'] ?? general_notification_mediums(), function ($channel) {
            return in_array($channel, general_notification_mediums());
        });
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->subject)
            ->line($this->message)
            ->line('From '.title());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->body;
    }
}
