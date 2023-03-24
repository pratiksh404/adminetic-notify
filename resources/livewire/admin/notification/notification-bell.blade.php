<div>
    @if (!is_null($notifications))
    @if ($notifications->count() > 0)
    <li class="onhover-dropdown" style="margin-right: 25px;">
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