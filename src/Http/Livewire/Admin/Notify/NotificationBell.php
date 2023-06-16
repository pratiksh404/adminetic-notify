<?php

namespace Adminetic\Notify\Http\Livewire\Admin\Notify;

use Livewire\Component;

class NotificationBell extends Component
{
    public $markAsRead = [];
    public $notifications;
    public $notifications_count = null;

    protected $listeners = ['general_push_notification' => 'generalPushNotification'];

    public function mount()
    {
        $this->fetchNotifications();
    }

    public function generalPushNotification()
    {
        $this->fetchNotifications();
    }

    public function updatedMarkAsRead()
    {
        if (count($this->markAsRead ?? []) > 0) {
            auth()->user()->unreadNotifications->whereIn('id', $this->markAsRead)->markAsRead();
            $this->fetchNotifications();
            $this->markAsRead = [];
            $this->emit('mark_as_read_success');
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->fetchNotifications();
        $this->emit('mark_as_read_success');
    }

    public function render()
    {
        return view('notify::livewire.admin.notify.notification-bell');
    }

    public function fetchNotifications()
    {
        $notifications = auth()->user()->unreadNotifications();
        $this->notifications = $notifications->limit(5)->get();
        $this->notifications_count = $notifications->count();

        if (config('notify.polling', true)) {
            $poll_interval_notifications = $notifications->whereBetween('created_at', [now()->subSeconds(config('notify.polling_intervals', '10000') / 1000), now()])->get();
            if ($poll_interval_notifications->count() > 0) {
                foreach ($poll_interval_notifications as $poll_interval_notification) {
                    $this->dispatchBrowserEvent('new_notification', $poll_interval_notification->data);
                }
            }
        }
    }
}
