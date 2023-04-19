<div>
    <style>
        .notification-tile:hover {
            // Write hovar elavate effect
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.4);
            transform: translateY(5px);
            transition: .2s;
        }
    </style>
    <div class="email-wrap" style="margin-top: 10vh;">
        <div class="row">
            <div class="col-xl-3 col-md-6 box-col-6">
                <div class="email-left-aside">
                    <div class="card">
                        <div class="card-body">
                            <div class="email-app-sidebar">
                                <div class="media">
                                    <div class="media-size-email"><img class="me-3 rounded-circle"
                                            src="{{ getProfilePlaceholder() }}" width="80"
                                            alt="{{ auth()->user()->name }}"></div>
                                    <div class="media-body">
                                        <h6 class="f-w-600">{{ auth()->user()->name }}</h6>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <ul class="nav main-menu" role="tablist">
                                    <li><a href="#" wire:click="$set('show_send_notification_panel',true)"><span
                                                class="title"><i class="icofont icofont-envelope me-2"></i>
                                                Send Notification</span></a>
                                    </li>
                                    <li><a href="#" wire:click="setAction(2)"><span class="title"><i
                                                    class="icon-import"></i> Unread
                                                Notifications</span><span
                                                class="badge pull-right">({{ $unreadNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li><a href="#" wire:click="setAction(3)"><span class="title"><i
                                                    class="icon-folder"></i> All
                                                Notifications</span><span
                                                class="badge pull-right">({{ $notifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click="setAction(4)"><span class="title"><i
                                                    class="fa fa-circle text-{{ severityColor(0) }}"></i>Insignificant
                                                Severity
                                                Notifications</span><span
                                                class="badge pull-right">({{ $insignificantSeverityNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click="setAction(5)"><span class="title"><i
                                                    class="fa fa-circle text-{{ severityColor(1) }}"></i>Low Severity
                                                Notifications</span><span
                                                class="badge pull-right">({{ $lowSeverityNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click="setAction(6)"><span class="title"><i
                                                    class="fa fa-circle text-{{ severityColor(2) }}"></i>Mid Severity
                                                Notifications</span><span
                                                class="badge pull-right">({{ $midSeverityNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click="setAction(7)"><span class="title"><i
                                                    class="fa fa-circle text-{{ severityColor(3) }}"></i>High Severity
                                                Notifications</span><span
                                                class="badge pull-right">({{ $highSeverityNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click="setAction(8)"><span class="title"><i
                                                    class="fa fa-circle text-{{ severityColor(4) }}"></i>Very High
                                                Severity
                                                Notifications</span><span
                                                class="badge pull-right">({{ $veryHighSeverityNotifications->count() ?? 0 }})</span></a>
                                    </li>
                                    <li>
                                        <hr>
                                    </li>
                                    @if ($notifications->count() > 0)
                                        @if (count(array_unique(array_column($notifications->pluck('data')->toArray(), 'group'))) > 0)
                                            @foreach (array_unique(array_column($notifications->pluck('data')->toArray(), 'group')) as $category)
                                                <li><a href="#"
                                                        wire:click="getCategoryNotfications('{{ $category }}')"><span
                                                            class="title"><i class="icon-bell"></i>
                                                            {{ $category }}
                                                        </span></a></li>
                                            @endforeach
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-6">
                <div class="email-right-aside">
                    <div class="card email-body" style="min-height: 80vh;">
                        <div class="row">
                            <div class="col-xl-4 col-md-12 box-md-12 pr-0" style="height: 70vh;overflow-y:auto">
                                <div class="pe-0 b-r-light"></div>
                                <div class="email-top">
                                    <div class="row">
                                        <div class="col">
                                            <h5>Inbox</h5>
                                        </div>
                                        <div class="col text-end">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" id="dropdownMenuButton"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">Load
                                                    ..</button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton"
                                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(45px, 44px);"
                                                    data-popper-placement="bottom-end">
                                                    <a class="dropdown-item" wire:click="$set('limit',5)"
                                                        href="#">5</a>
                                                    <a class="dropdown-item" wire:click="$set('limit',10)"
                                                        href="#">10</a>
                                                    <a class="dropdown-item" wire:click="$set('limit',15)"
                                                        href="#">15</a>
                                                    <a class="dropdown-item" wire:click="$set('limit',0)"
                                                        href="#">15+</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pb-0" style="padding: 10px;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div wire:loading.flex wire:target="setAction,getCategoryNotfications">
                                                <div style="width:100%;align-items: center;justify-content: center;">
                                                    <div class="loader-box" style="margin:auto">
                                                        <div class="loader-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading.remove wire:target="setAction,getCategoryNotfications">
                                        @if ($active_notifications->count() > 0)
                                            @foreach ($active_notifications as $notification)
                                                @if ($loop->iteration <= $limit)
                                                    <div class="card mb-1 notification-tile">
                                                        <div class="card-body shadow-sm p-2">
                                                            <a href="#"
                                                                wire:click="show_notification('{{ $notification->id }}')"
                                                                class="media">
                                                                <i title="{{ severity($notification->data['severity'] ?? 0) }}"
                                                                    class="fa fa-circle text-{{ severityColor($notification->data['severity'] ?? 0) ?? 'primary' }}"></i>
                                                                <div class="media-size-email"><img
                                                                        class="me-3 rounded-circle" width="80"
                                                                        src="{{ ($notification->data['from'] ?? 1) == 1 ? asset('adminetic/static/system.gif') : getProfilePlaceholder(\App\Models\User::find($notification->data['user_id'])->profile ?? null) }}"
                                                                        alt="{{ ($notification->data['from'] ?? 1) == 1 ? 'From System' : \App\Models\User::find($notification->data['user_id'])->name ?? 'Unknown' }}">
                                                                </div>
                                                                <div class="media-body">
                                                                    <h6 style='font-size" 10px'
                                                                        title="{{ $notification->data['title'] ?? '' }}">
                                                                        {{ \Illuminate\Support\Str::limit($notification->data['title'], 20) }}
                                                                    </h6>
                                                                    <small>
                                                                        ({{ $notification->created_at->toDateString() }})
                                                                        ||
                                                                        {{ $notification->created_at->diffForHumans() }}
                                                                    </small>
                                                                    <p>{!! $notification->data[''] ?? '' !!}</p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endif
                                            @endforeach
                                            <button wire:loading wire:target="loadMore"
                                                class="btn btn-outline-primary" disabled style="width: 100%">Loading
                                                ...</button>
                                            <button wire:loading.remove wire:target="loadMore"
                                                class="btn btn-outline-primary" wire:click="loadMore"
                                                style="width: 100%">Load
                                                More ...</button>
                                        @else
                                            <button class="btn btn-outline-danger" disabled style="width: 100%">No
                                                notifications available</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-12 box-md-12 pl-0">
                                <div class="email-right-aside">
                                    <div class="email-body radius-left">
                                        <div class="ps-0">
                                            @if ($show_send_notification_panel)
                                                <form wire:submit.prevent="send">
                                                    @csrf
                                                    <div class="email-compose" wire:ignore>
                                                        <div class="email-top compose-border">
                                                            <div class="row">
                                                                <div class="col-sm-8 xl-50">
                                                                    <h4 class="mb-0">New Message</h4>
                                                                </div>
                                                                <div class="col-sm-4 btn-middle xl-50">
                                                                    <button wire:loading.remove wire:target="send"
                                                                        class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0 w-100"
                                                                        type="submit"><i
                                                                            class="fa fa-paper-plane me-2"></i>
                                                                        SEND</button>
                                                                    <button wire:loading wire:target="send" disabled
                                                                        class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0 w-100"
                                                                        type="button"><i
                                                                            class="fa fa-paper-plane me-2"></i>
                                                                        SENDING ...</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="email-wrapper">
                                                            <div class="theme-form">
                                                                <div class="row">
                                                                    <div class="col-12 mb-3">
                                                                        <label for="audience">To</label>
                                                                        <select id="audience" class="form-control"
                                                                            style="width:100%"
                                                                            wire:model.defer="audience" multiple>
                                                                            @isset($users)
                                                                                @foreach ($users as $user)
                                                                                    <option value="{{ $user->id }}">
                                                                                        {{ $user->name . ' - ' . $user->email }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endisset
                                                                        </select>
                                                                        @error('audience')
                                                                            <br> <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="text-muted">Message</label>
                                                                        <textarea name="text-box" id="message" class="form-control" wire:model.defer="message"></textarea>
                                                                        @error('message')
                                                                            <br> <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div wire:loading.flex wire:target="show_notification">
                                                            <div
                                                                style="width:100%;align-items: center;justify-content: center;">
                                                                <div class="loader-box" style="margin:auto">
                                                                    <div class="loader-2"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:loading.remove wire:target="show_notification">
                                                    @if (!is_null($active_notification))
                                                        <div style="margin-right:12px"
                                                            class="ribbon ribbon-clip-right ribbon-right ribbon-{{ severityColor($active_notification->data['severity'] ?? 0) ?? 'primary' }}">
                                                            <span
                                                                style="margin-right: 100px">{{ severity($active_notification->data['severity'] ?? 0) ??
                                                                    'Not
                                                                                                                                                                                    Specified' }}</span>
                                                        </div>
                                                        <div class="email-content">
                                                            <div class="email-top">
                                                                <div class="row">
                                                                    <div class="col-md-6 xl-100 col-sm-12">
                                                                        <div class="media"><img
                                                                                class="me-3 rounded-circle"
                                                                                width="80"
                                                                                src="{{ ($active_notification->data['from'] ?? 1) == 1 ? asset('adminetic/static/system.gif') : getProfilePlaceholder(\App\Models\User::find($active_notification->data['user_id'])->profile ?? null) }}"
                                                                                alt="{{ ($active_notification->data['from'] ?? 1) == 1 ? 'From System' : \App\Models\User::find($active_notification->data['user_id'])->name ?? 'Unknown' }}">
                                                                            <div class="media-body">
                                                                                <h6>{!! $active_notification->data['title'] !!}
                                                                                    <small>
                                                                                        ({{ $active_notification->created_at->toDateString() }})
                                                                                        ||
                                                                                        {{ $active_notification->created_at->diffForHumans() }}
                                                                                    </small>
                                                                                </h6>
                                                                                @if (!is_null($active_notification->read_at))
                                                                                    <div class="badge badge-primary">
                                                                                        Read
                                                                                        At :
                                                                                        ({{ $active_notification->read_at->toDateString() }})
                                                                                        ||
                                                                                        {{ $active_notification->read_at->diffForHumans() }}
                                                                                    </div>
                                                                                @endif
                                                                                <p>{{ $notification->data[''] ?? '' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12 xl-100">
                                                                        <div class="float-end d-flex">
                                                                            <p class="user-emailid">
                                                                                @if (isset($active_notification->data['user_id']))
                                                                                    {{ \App\Models\User::find($active_notification->data['user_id'])->email }}
                                                                                @else
                                                                                    {{ env('MAIL_USERNAME') }}
                                                                                @endif
                                                                            </p>
                                                                            <i class="fa fa-star-o f-18 mt-1"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="email-wrapper">
                                                                @if (isset($active_notification->data['message']))
                                                                    {!! $active_notification->data['message'] !!}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initializeMyNotification');
                Livewire.on('initialize_my_notfication', function() {
                    $('#audience').select2({
                        placeholder: 'Select Receivers',
                        width: 'style'
                    });

                    $('#audience').on('change', function(e) {
                        var data = $('#audience').select2("val");
                        @this.set('audience', data);
                    });
                });

                Livewire.on('message_send_success', function() {
                    $.notify({
                        title: "Alert",
                        message: 'Message sent successfully',
                    }, {
                        type: 'primary',
                        allow_dismiss: false,
                        newest_on_top: true,
                        mouse_over: false,
                        showProgressbar: false,
                        spacing: 10,
                        timer: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        offset: {
                            x: 30,
                            y: 30
                        },
                        delay: 1000,
                        z_index: 10000,
                        animate: {
                            enter: 'animated bounce',
                            exit: 'animated bounce'
                        }
                    });
                });
            });

            Livewire.on('initialize_my_notfication', function() {
                if (document.getElementById('message')) {
                    CKEDITOR.replace('message', {
                        extraPlugins: 'autocorrect,chart,youtube,notification,btgrid,templates',
                        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                        filebrowserUploadMethod: 'form',
                        embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
                        width: '100%'
                    }).on('change', function(event) {
                        @this.set('message', event.editor.getData());
                    })
                }
            });
        </script>
    @endpush
</div>
