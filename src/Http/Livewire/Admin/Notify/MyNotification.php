<?php

namespace Adminetic\Notify\Http\Livewire\Admin\Notify;

use Adminetic\Notify\Events\GeneralPushNotificationEvent;
use Adminetic\Notify\Notifications\GeneralNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class MyNotification extends Component
{
    public $users;

    public $given_id;

    public $notifications;
    public $unreadNotifications;

    // Severity Notifications
    public $insignificantSeverityNotifications;
    public $lowSeverityNotifications;
    public $midSeverityNotifications;
    public $highSeverityNotifications;
    public $veryHighSeverityNotifications;

    // Active Notifications
    public $active_notifications;
    public $active_notification;

    // Action
    public $action = 1;
    public $limit = 5;
    public $show_send_notification_panel = true;

    // Send Message
    public $audience = [];
    public $message;

    protected $listeners = ['initializeMyNotification' => 'initialize_my_notfication', 'general_push_notification' => '$refresh'];

    public function mount($given_id = null)
    {
        $this->mapNotifications();
        $this->given_id = $given_id;
        $this->show_notification($given_id);
        $this->users = Cache::get('users', User::latest()->get());
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function send()
    {
        $this->validate([
            'audience' => 'required',
            'message' => 'required|max:55000',
        ]);

        $data = [
            'title' => 'Message from '.auth()->user()->name,
            'message' => $this->message,
            'subject' => 'Message from '.auth()->user()->name,
            'action' => null,
            'color' => 'primary',
            'type' => GeneralNotification::MESSAGE,
            'severity' => GeneralNotification::MID,
            'icon' => 'fab fa-rocketchat',
            'channels' => ['database'],
            'audience' => $this->audience,
            'from' => 2,
            'category' => 'Message',
            'user_id' => auth()->user()->id,
        ];

        $audience = User::find($this->audience);
        Notification::send($audience, new GeneralNotification($data));
        event(new GeneralPushNotificationEvent($data));

        $this->emit('message_send_success');
    }

    public function updatedShowSendNotificationPanel()
    {
        $this->action = 2;
        $this->active_notifications = $this->unreadNotifications;
    }

    public function loadMore()
    {
        $this->limit = $this->limit + 5;
    }

    public function show_notification($id)
    {
        if (! is_null($id)) {
            $this->active_notification = $this->notifications->first(function ($n) use ($id) {
                return $n->id == $id;
            });
            $this->active_notification->update([
                'read_at' => Carbon::now(),
            ]);
            $this->mapNotifications();
            $this->show_send_notification_panel = false;
        }
    }

    public function initialize_my_notfication()
    {
        $this->emit('initialize_my_notfication');
    }

    public function render()
    {
        return view('notify::livewire.admin.notify.my-notification');
    }

    public function getCategoryNotfications($category)
    {
        $this->active_notifications = $this->notifications->filter(function ($n) use ($category) {
            return ($n->data['category'] ?? null) == $category;
        });
    }

    public function updatedAction()
    {
        $this->show_send_notification_panel = false;
        $action = $this->action ?? 1;
        if ($action == 1 || $action == 2) {
            $this->active_notifications = $this->unreadNotifications;
        } elseif ($action == 3) {
            $this->active_notifications = $this->notifications;
        } elseif ($action == 4) {
            $this->active_notifications = $this->insignificantSeverityNotifications;
        } elseif ($action == 5) {
            $this->active_notifications = $this->lowSeverityNotifications;
        } elseif ($action == 6) {
            $this->active_notifications = $this->midSeverityNotifications;
        } elseif ($action == 7) {
            $this->active_notifications = $this->highSeverityNotifications;
        } elseif ($action == 8) {
            $this->active_notifications = $this->veryHighSeverityNotifications;
        }
    }

    private function mapNotifications()
    {
        $notifications = auth()->user()->notifications;
        $this->notifications = $notifications;
        $unreadNotifications = auth()->user()->unreadNotifications;
        $this->unreadNotifications = $unreadNotifications;

        $this->active_notifications = $unreadNotifications;

        // Severity Notifications
        $this->insignificantSeverityNotifications = $notifications->filter(function ($n) {
            return ($n->data['severity'] ?? null) == 0;
        });

        $this->lowSeverityNotifications = $notifications->filter(function ($n) {
            return ($n->data['severity'] ?? null) == 1;
        });

        $this->midSeverityNotifications = $notifications->filter(function ($n) {
            return ($n->data['severity'] ?? null) == 2;
        });

        $this->highSeverityNotifications = $notifications->filter(function ($n) {
            return ($n->data['severity'] ?? null) == 3;
        });

        $this->veryHighSeverityNotifications = $notifications->filter(function ($n) {
            return ($n->data['severity'] ?? null) == 4;
        });
    }
}
