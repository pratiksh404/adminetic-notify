<div>
    @if (!is_null($notifications))
    @if ($notifications->count() > 0)
    <li class="onhover-dropdown" style="margin-right: 25px;" {{config('notify.polling',true) ? ("wire:poll." . config("notify.polling_intervals","10000"). "ms=fetchNotifications") : ""}}>
        <div class="notification-box">
            <svg>
                <use href="{{asset('adminetic/assets/svg/icon-sprite.svg#notification')}}"></use>
            </svg><span class="badge rounded-pill badge-secondary"
                style="position: absolute;bottom: 10px;">{{$notifications_count ?? 0}}</span>
        </div>
        <div class="onhover-show-div notification-dropdown" style="width: 30vw">
            <h6 class="f-18 mb-0 dropdown-title">
                Notitications
                <span class="pull-right">
                    <a wire:click="markAllAsRead" title="Mark all {{$notifications_count ?? 0}} notifications ?"
                        style="font-size: 12px;font-weight: lighter;border-bottom: groove;">Mark all as read</a>
                </span>
            </h6>
            <ul>
                @foreach ($notifications as $notification)
                <li class="b-l-{{$notification->data['color'] ?? 'primary'}} border-4">
                    <div class="row">
                        <div class="col-1"><i
                                class="{{$notification->data['icon'] ?? 'fa fa-bell'}} mx-2 text-{{$notification->data['color'] ?? 'primary'}}"></i>
                        </div>
                        <div class="col-8">
                            <a class="router" href="{{route('show_notification',['id' => $notification->id])}}"
                                style="text-decoration: none">
                                <b class="text-dark">{!! $notification->data['title'] !!}</b>
                                <br>
                                <div class="text-dark" style="font-size: 10px">
                                    {!! $notification->data['subject'] ?? '' !!}
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <span class="pull-right">
                                <span class="text-dark"
                                    wire:poll.300000ms.visible>{{$notification->created_at->diffForHumans()}}</span>
                                <input class="checkbox_animated mx-1" type="checkbox" wire:model="markAsRead"
                                    value="{{$notification->id}}" title="Mark As Read">
                            </span>
                        </div>
                    </div>
                </li>
                @endforeach
                <li><a class="f-w-700" href="{{route('my_notification')}}">Check all {{$notifications_count ?? ''}}
                        notification</a></li>
            </ul>
        </div>
    </li>
    @endif
    @endif


    @push('livewire_third_party')
    <script>
        $(function(){
            window.addEventListener('new_notification',event => {
                var data = event.detail;
                var icon = data.icon != null ? data.icon : 'fa fa-bell';
                $.notify('<i class="' + icon + ' text-'+color+'"></i><strong class="text-'+data.color+'">' + data.title + '</strong> <br> <p class="p-4">' + data.message + '</p>', {
                 type: 'theme',
                 allow_dismiss: data.allow_dismiss != null ? data.allow_dismiss : true,
                 newest_on_top: data.newest_on_top != null ? data.newest_on_top : true,
                 mouse_over: data.mouse_over != null ? data.mouse_over : false,
                 showProgressbar:data.showProgressbar != null ? data.showProgressbar : false,
                 spacing:data.spacing != null ? data.spacing : 10,
                 timer:data.timer != null ? data.timer : 8000,
                 placement:{
                   from: String(data.placement_from),
                   align: String(data.placement_align)
                 },
                 offset:{
                   x:30,
                   y:30
                 },
                 delay:data.delay != null ? data.delay : 1000 ,
                 z_index:10000,
                 animate:{
                    enter:'animated ' + String(data.animate_enter),
                    exit:'animated ' + String(data.animate_exit)
                 }
                 });
            
               // Browser Notification
                if (window.Notification) {
                    console.log('Notifications are supported!');
                } else {
                    alert('Notifications aren\'t supported on your browser! :(');
                }

                  new Notification(data.title, {
                    body: data.message, // content for the alert
                  });
            })
            Livewire.on('mark_as_read_success',function(){
            $.notify({
                       title: "Alert",
                       message:'Marked as read',
                    },
                    {
                       type:'primary',
                       allow_dismiss:false,
                       newest_on_top:true ,
                       mouse_over:false,
                       showProgressbar:false,
                       spacing:10,
                       timer:2000,
                       placement:{
                         from:'bottom',
                         align:'right'
                       },
                       offset:{
                         x:30,
                         y:30
                       },
                       delay:1000 ,
                       z_index:10000,
                       animate:{
                         enter:'animated bounce',
                         exit:'animated bounce'
                     }
                   });
            });
        });
    </script>
    @endpush
</div>