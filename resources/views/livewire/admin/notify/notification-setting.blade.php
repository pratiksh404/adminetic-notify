<div>
    <style>
        .email-wrap a:hover {
            color: white !important;
            background-color: #0d6efd !important;
        }
    </style>
    <div class="email-wrap bookmark-wrap" style="margin-top: 10vh;">
        <div class="row">
            <div class="col-xl-3 box-col-6">
                <div class="email-left-aside">
                    <div class="card">
                        <div class="card-body">
                            <div class="email-app-sidebar left-bookmark">
                                <div class="media">
                                    <div class="media-size-email"><img class="me-3 rounded-circle"
                                            src="{{asset('adminetic/static/bell.gif')}}" alt="Bell" width="80"></div>
                                    <div class="media-body">
                                        <h6 class="f-w-600 mt-3">Notification Settings</h6>
                                        <p>{{\Illuminate\Support\Str::ucfirst(str_replace('_','
                                            ',$active_setting['name'] ?? ''))}}</p>
                                    </div>
                                </div>
                                <hr>
                                <b>Create Setting</b> <br>
                                <form wire:submit.prevent="createNotifySetting" method="post">
                                    <div class="mb-3">
                                        <label for="setting_name">Setting Name</label>
                                        <input type="text" id="setting_name" wire:model.defer="notify_setting.name" class="form-control" placeholder="Notification Setting Name">
                                    </div>
                                    <br>
                                    <div class="mb-3">
                                        <label for="setting_group">Setting Group</label>
                                        <input type="text" id="setting_group" wire:model.defer="notify_setting.group" class="form-control" placeholder="Notification Setting Group">
                                    </div>
                                    <br>
                                    <button class="btn btn-primary btn-air-primary" type="submit" style="width:100%">Save</button>
                                </form>
                                <hr>
                                @if (!is_null($settings))
                                <ul class="nav main-menu" role="tablist">
                                    @foreach ($settings as $group_name => $group_settings)
                                    <li class="nav-item"><span class="main-title"> {{strtoupper($group_name)}}</span>
                                    </li>
                                    @foreach ($group_settings as $setting_name => $setting)
                                    <li style="{{$active_group == $group_name && $active_setting_name == $setting_name ? "
                                        background-color: #0d6efd;" : "" }}">
                                        <a href="#"
                                            style="{{$active_group == $group_name && $active_setting_name == $setting_name ? "
                                            color: white;" : "" }}"
                                            wire:click="select_setting('{{$group_name}}', '{{$setting_name}}')"
                                            class="d-flex justify-content-between">
                                            <span>
                                                -
                                                {{\Illuminate\Support\Str::ucfirst(str_replace('_','
                                                ',$setting['name']))}}
                                            </span>
                                            <div class="badges">
                                                <span style="color:white;"
                                                    class="badge badge-{{$setting['active'] ? 'success' : 'danger'}} mx-2">{{$setting['active']
                                                    ? 'On' : 'Off'}}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                    <hr>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-12 box-col-12">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            @if (!is_null($active_setting))
                            <div class="card mb-0" style="min-height: 60vh">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div wire:ignore wire:loading.flex wire:target="save,select_setting">
                                                <div style="width:100%;align-items: center;justify-content: center;">
                                                    <div class="loader-box" style="margin:auto">
                                                        <div class="loader-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading.remove wire:target="save,select_setting">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">
                                                {{\Illuminate\Support\Str::ucfirst(str_replace('_','
                                                ',$active_setting['name'] ?? ''))}}</span>
                                            </h6>

                                        </div>
                                        <div class="card-body pb-0">
                                            @if (!is_null($active_group))
                                            <div
                                                class="ribbon ribbon-bookmark ribbon-{{severityColor($active_setting['default_severity'] ?? 0)}}">
                                                {{strtoupper($active_group)}}</div>
                                            @endif
                                            <div class="row">
                                                <div class="col-12">
                                                    <label>Default Title</label>
                                                    <input type="text" wire:model="default_title" class="form-control"
                                                        placeholder="Default title to show in notification">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>Active</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="flexSwitchCheckChecked"
                                                            wire:model="active" type="checkbox" data-onstyle="secondary"
                                                            checked>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Severity</label>
                                                    <select class="form-control" wire:model="default_severity">
                                                        <option value="0">INSIGNIFICANT</option>
                                                        <option value="1">LOW</option>
                                                        <option value="2">MID</option>
                                                        <option value="3">HIGH</option>
                                                        <option value="4">VERY HIGH</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Type</label>
                                                    <select class="form-control" wire:model="default_type">
                                                        <option value="1">INFO</option>
                                                        <option value="2">ALERT</option>
                                                        <option value="3">REMINDER</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3" wire:ignore>
                                                    <label for="icon">Icon</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i
                                                                    id="showIcon" class="fas fa-icons"></i></span>
                                                        </div>
                                                        <button type="button" class="btn btn-primary" id="iconPicker"
                                                            data-iconpicker-input="#icon"
                                                            data-iconpicker-preview="#showIcon">Select Icon</button>
                                                        <input type="hidden" name="icon" id="icon" wire:model="icon"
                                                            value="fas fa-concierge-bell">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label><u>Channels</u></label>
                                                    <hr>
                                                    @foreach (config('notify.available_notification_medium_in_system')
                                                    as $channel)
                                                    <input type="checkbox" wire:model="channels" value="{{$channel}}">
                                                    {{$channel}}
                                                    <br>
                                                    @endforeach
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn btn-primary btn-air-primary mb-3"
                                                                wire:click="showaudience" style="width: 100%">
                                                                <div class="d-flex justify-content-between">
                                                                    <b>Notfication audience</b>
                                                                    <span>Total audience
                                                                        <b><u>{{count($audience ?? [])}}</u></b></span>
                                                                </div>
                                                            </button>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div wire:ignore wire:loading.flex
                                                                        wire:target="showaudience">
                                                                        <div
                                                                            style="width:100%;align-items: center;justify-content: center;">
                                                                            <div class="loader-box" style="margin:auto">
                                                                                <div class="loader-2"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div wire:loading.remove wire:target="showaudience">
                                                                @if (!is_null($show_audience) && !is_null($roles))
                                                                <div class="row">
                                                                    <div class="col-sm-3 tabs-responsive-side">
                                                                        <div class="nav flex-column nav-pills border-tab nav-left"
                                                                            id="v-pills-tab" role="tablist"
                                                                            aria-orientation="vertical">
                                                                            @foreach ($roles as $role)
                                                                            <a class="nav-link {{$loop->first ? 'active' : ''}}"
                                                                                id="v-pills-role{{$role->id}}-tab"
                                                                                data-bs-toggle="pill"
                                                                                href="#v-pills-role{{$role->id}}"
                                                                                role="tab"
                                                                                aria-controls="v-pills-role{{$role->id}}"
                                                                                aria-selected="true"
                                                                                title="">{{strtoupper($role->name)}}</a>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-9" wire:ignore>
                                                                        <div class="tab-content"
                                                                            id="v-pills-tabContent">
                                                                            @foreach ($roles as $role)
                                                                            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}"
                                                                                id="v-pills-role{{$role->id}}"
                                                                                role="tabpanel"
                                                                                aria-labelledby="v-pills-role{{$role->id}}-tab">

                                                                                <div class="row">
                                                                                    @if ($role->users->count() > 0)
                                                                                    @foreach($role->users->chunk(10) as $user_group)
                                                                                  @if ($user_group->count() > 0)
                                                                                        <div class="col-lg-4">
                                                                                        @foreach($user_group as $user)
                                                                                        <input type="checkbox"
                                                                                            value="{{$user->id}}"
                                                                                            wire:model="audience">
                                                                                        {{$user->name}}
                                                                                        <br>
                                                                                        @endforeach
                                                                                    </div>
                                                                                    <br>
                                                                                  @endif
                                                                                    @endforeach
                                                                                    @endif
                                                                                </div>

                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="m-portlet__body">


                                            <div class="mb-3">
                                                <div class="row">
                                                    <label
                                                        class="col-xl-2 col-sm-12 col-md-12 col-form-label">Placement</label>
                                                    <div class="col-xl-4 col-sm-12 col-md-12 mb-md-4 mb-2">
                                                        <select class="form-select form-control"
                                                            wire:model="placement_from"
                                                            id="bootstrap-notify-placement-from">
                                                            <option value="top">Top</option>
                                                            <option value="bottom">Bottom</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-4 col-md-12 col-sm-12 mb-4">
                                                        <select class="form-select form-control"
                                                            wire:model="placement_align"
                                                            id="bootstrap-notify-placement-align">
                                                            <option value="left">Left</option>
                                                            <option value="right" select.form-selected="">Right
                                                            </option>
                                                            <option value="center">Center</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label
                                                        class="col-xl-2 col-sm-12 col-md-12 col-form-label">Animation</label>
                                                    <div class="col-xl-4 col-md-12 col-sm-12 mb-md-4 mb-2">
                                                        <select class="form-select form-control"
                                                            wire:model="animate_enter" id="bootstrap-notify-enter">
                                                            <optgroup label="Attention Seekers">
                                                                <option value="bounce">bounce</option>
                                                                <option value="flash">flash</option>
                                                                <option value="pulse">pulse</option>
                                                                <option value="rubberBand">rubberBand</option>
                                                                <option value="shake">shake</option>
                                                                <option value="swing">swing</option>
                                                                <option value="tada">tada</option>
                                                                <option value="wobble">wobble</option>
                                                                <option value="jello">jello</option>
                                                            </optgroup>
                                                            <optgroup label="Bouncing Entrances">
                                                                <option value="bounceIn">bounceIn</option>
                                                                <option value="bounceInDown">bounceInDown</option>
                                                                <option value="bounceInLeft">bounceInLeft</option>
                                                                <option value="bounceInRight">bounceInRight</option>
                                                                <option value="bounceInUp">bounceInUp</option>
                                                            </optgroup>
                                                            <optgroup label="Bouncing Exits">
                                                                <option value="bounceOut">bounceOut</option>
                                                                <option value="bounceOutDown">bounceOutDown</option>
                                                                <option value="bounceOutLeft">bounceOutLeft</option>
                                                                <option value="bounceOutRight">bounceOutRight
                                                                </option>
                                                                <option value="bounceOutUp">bounceOutUp</option>
                                                            </optgroup>
                                                            <optgroup label="Fading Entrances">
                                                                <option value="fadeIn">fadeIn</option>
                                                                <option value="fadeInDown">fadeInDown</option>
                                                                <option value="fadeInDownBig">fadeInDownBig</option>
                                                                <option value="fadeInLeft">fadeInLeft</option>
                                                                <option value="fadeInLeftBig">fadeInLeftBig</option>
                                                                <option value="fadeInRight">fadeInRight</option>
                                                                <option value="fadeInRightBig">fadeInRightBig
                                                                </option>
                                                                <option value="fadeInUp">fadeInUp</option>
                                                                <option value="fadeInUpBig">fadeInUpBig</option>
                                                            </optgroup>
                                                            <optgroup label="Fading Exits">
                                                                <option value="fadeOut">fadeOut</option>
                                                                <option value="fadeOutDown">fadeOutDown</option>
                                                                <option value="fadeOutDownBig">fadeOutDownBig
                                                                </option>
                                                                <option value="fadeOutLeft">fadeOutLeft</option>
                                                                <option value="fadeOutLeftBig">fadeOutLeftBig
                                                                </option>
                                                                <option value="fadeOutRight">fadeOutRight</option>
                                                                <option value="fadeOutRightBig">fadeOutRightBig
                                                                </option>
                                                                <option value="fadeOutUp">fadeOutUp</option>
                                                                <option value="fadeOutUpBig">fadeOutUpBig</option>
                                                            </optgroup>
                                                            <optgroup label="Flippers">
                                                                <option value="flip">flip</option>
                                                                <option value="flipInX">flipInX</option>
                                                                <option value="flipInY">flipInY</option>
                                                                <option value="flipOutX">flipOutX</option>
                                                                <option value="flipOutY">flipOutY</option>
                                                            </optgroup>
                                                            <optgroup label="Lightspeed">
                                                                <option value="lightSpeedIn">lightSpeedIn</option>
                                                                <option value="lightSpeedOut">lightSpeedOut</option>
                                                            </optgroup>
                                                            <optgroup label="Rotating Entrances">
                                                                <option value="rotateIn">rotateIn</option>
                                                                <option value="rotateInDownLeft">rotateInDownLeft
                                                                </option>
                                                                <option value="rotateInDownRight">rotateInDownRight
                                                                </option>
                                                                <option value="rotateInUpLeft">rotateInUpLeft
                                                                </option>
                                                                <option value="rotateInUpRight">rotateInUpRight
                                                                </option>
                                                            </optgroup>
                                                            <optgroup label="Rotating Exits">
                                                                <option value="rotateOut">rotateOut</option>
                                                                <option value="rotateOutDownLeft">rotateOutDownLeft
                                                                </option>
                                                                <option value="rotateOutDownRight">
                                                                    rotateOutDownRight</option>
                                                                <option value="rotateOutUpLeft">rotateOutUpLeft
                                                                </option>
                                                                <option value="rotateOutUpRight">rotateOutUpRight
                                                                </option>
                                                            </optgroup>
                                                            <optgroup label="Sliding Entrances">
                                                                <option value="slideInUp">slideInUp</option>
                                                                <option value="slideInDown">slideInDown</option>
                                                                <option value="slideInLeft">slideInLeft</option>
                                                                <option value="slideInRight">slideInRight</option>
                                                            </optgroup>
                                                            <optgroup label="Sliding Exits">
                                                                <option value="slideOutUp">slideOutUp</option>
                                                                <option value="slideOutDown">slideOutDown</option>
                                                                <option value="slideOutLeft">slideOutLeft</option>
                                                                <option value="slideOutRight">slideOutRight</option>
                                                            </optgroup>
                                                            <optgroup label="Zoom Entrances">
                                                                <option value="zoomIn">zoomIn</option>
                                                                <option value="zoomInDown">zoomInDown</option>
                                                                <option value="zoomInLeft">zoomInLeft</option>
                                                                <option value="zoomInRight">zoomInRight</option>
                                                                <option value="zoomInUp">zoomInUp</option>
                                                            </optgroup>
                                                            <optgroup label="Zoom Exits">
                                                                <option value="zoomOut">zoomOut</option>
                                                                <option value="zoomOutDown">zoomOutDown</option>
                                                                <option value="zoomOutLeft">zoomOutLeft</option>
                                                                <option value="zoomOutRight">zoomOutRight</option>
                                                                <option value="zoomOutUp">zoomOutUp</option>
                                                            </optgroup>
                                                            <optgroup label="Specials">
                                                                <option value="hinge">hinge</option>
                                                                <option value="rollIn">rollIn</option>
                                                                <option value="rollOut">rollOut</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-4 col-md-12 col-sm-12 mb-4">
                                                        <select class="form-select form-control"
                                                            wire:model="animate_exit" id="bootstrap-notify-exit">
                                                            <optgroup label="Attention Seekers">
                                                                <option value="bounce">bounce</option>
                                                                <option value="flash">flash</option>
                                                                <option value="pulse">pulse</option>
                                                                <option value="rubberBand">rubberBand</option>
                                                                <option value="shake">shake</option>
                                                                <option value="swing">swing</option>
                                                                <option value="tada">tada</option>
                                                                <option value="wobble">wobble</option>
                                                                <option value="jello">jello</option>
                                                            </optgroup>
                                                            <optgroup label="Bouncing Entrances">
                                                                <option value="bounceIn">bounceIn</option>
                                                                <option value="bounceInDown">bounceInDown</option>
                                                                <option value="bounceInLeft">bounceInLeft</option>
                                                                <option value="bounceInRight">bounceInRight</option>
                                                                <option value="bounceInUp">bounceInUp</option>
                                                            </optgroup>
                                                            <optgroup label="Bouncing Exits">
                                                                <option value="bounceOut">bounceOut</option>
                                                                <option value="bounceOutDown">bounceOutDown</option>
                                                                <option value="bounceOutLeft">bounceOutLeft</option>
                                                                <option value="bounceOutRight">bounceOutRight
                                                                </option>
                                                                <option value="bounceOutUp">bounceOutUp</option>
                                                            </optgroup>
                                                            <optgroup label="Fading Entrances">
                                                                <option value="fadeIn">fadeIn</option>
                                                                <option value="fadeInDown">fadeInDown</option>
                                                                <option value="fadeInDownBig">fadeInDownBig</option>
                                                                <option value="fadeInLeft">fadeInLeft</option>
                                                                <option value="fadeInLeftBig">fadeInLeftBig</option>
                                                                <option value="fadeInRight">fadeInRight</option>
                                                                <option value="fadeInRightBig">fadeInRightBig
                                                                </option>
                                                                <option value="fadeInUp">fadeInUp</option>
                                                                <option value="fadeInUpBig">fadeInUpBig</option>
                                                            </optgroup>
                                                            <optgroup label="Fading Exits">
                                                                <option value="fadeOut">fadeOut</option>
                                                                <option value="fadeOutDown">fadeOutDown</option>
                                                                <option value="fadeOutDownBig">fadeOutDownBig
                                                                </option>
                                                                <option value="fadeOutLeft">fadeOutLeft</option>
                                                                <option value="fadeOutLeftBig">fadeOutLeftBig
                                                                </option>
                                                                <option value="fadeOutRight">fadeOutRight</option>
                                                                <option value="fadeOutRightBig">fadeOutRightBig
                                                                </option>
                                                                <option value="fadeOutUp">fadeOutUp</option>
                                                                <option value="fadeOutUpBig">fadeOutUpBig</option>
                                                            </optgroup>
                                                            <optgroup label="Flippers">
                                                                <option value="flip">flip</option>
                                                                <option value="flipInX">flipInX</option>
                                                                <option value="flipInY">flipInY</option>
                                                                <option value="flipOutX">flipOutX</option>
                                                                <option value="flipOutY">flipOutY</option>
                                                            </optgroup>
                                                            <optgroup label="Lightspeed">
                                                                <option value="lightSpeedIn">lightSpeedIn</option>
                                                                <option value="lightSpeedOut">lightSpeedOut</option>
                                                            </optgroup>
                                                            <optgroup label="Rotating Entrances">
                                                                <option value="rotateIn">rotateIn</option>
                                                                <option value="rotateInDownLeft">rotateInDownLeft
                                                                </option>
                                                                <option value="rotateInDownRight">rotateInDownRight
                                                                </option>
                                                                <option value="rotateInUpLeft">rotateInUpLeft
                                                                </option>
                                                                <option value="rotateInUpRight">rotateInUpRight
                                                                </option>
                                                            </optgroup>
                                                            <optgroup label="Rotating Exits">
                                                                <option value="rotateOut">rotateOut</option>
                                                                <option value="rotateOutDownLeft">rotateOutDownLeft
                                                                </option>
                                                                <option value="rotateOutDownRight">
                                                                    rotateOutDownRight</option>
                                                                <option value="rotateOutUpLeft">rotateOutUpLeft
                                                                </option>
                                                                <option value="rotateOutUpRight">rotateOutUpRight
                                                                </option>
                                                            </optgroup>
                                                            <optgroup label="Sliding Entrances">
                                                                <option value="slideInUp">slideInUp</option>
                                                                <option value="slideInDown">slideInDown</option>
                                                                <option value="slideInLeft">slideInLeft</option>
                                                                <option value="slideInRight">slideInRight</option>
                                                            </optgroup>
                                                            <optgroup label="Sliding Exits">
                                                                <option value="slideOutUp">slideOutUp</option>
                                                                <option value="slideOutDown">slideOutDown</option>
                                                                <option value="slideOutLeft">slideOutLeft</option>
                                                                <option value="slideOutRight">slideOutRight</option>
                                                            </optgroup>
                                                            <optgroup label="Zoom Entrances">
                                                                <option value="zoomIn">zoomIn</option>
                                                                <option value="zoomInDown">zoomInDown</option>
                                                                <option value="zoomInLeft">zoomInLeft</option>
                                                                <option value="zoomInRight">zoomInRight</option>
                                                                <option value="zoomInUp">zoomInUp</option>
                                                            </optgroup>
                                                            <optgroup label="Zoom Exits">
                                                                <option value="zoomOut">zoomOut</option>
                                                                <option value="zoomOutDown">zoomOutDown</option>
                                                                <option value="zoomOutLeft">zoomOutLeft</option>
                                                                <option value="zoomOutRight">zoomOutRight</option>
                                                                <option value="zoomOutUp">zoomOutUp</option>
                                                            </optgroup>
                                                            <optgroup label="Specials">
                                                                <option value="hinge">hinge</option>
                                                                <option value="rollIn">rollIn</option>
                                                                <option value="rollOut">rollOut</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-6 col-form-label">Allow
                                                            dismiss</label>
                                                        <div class="col-sm-8 col-6">
                                                            <div class="media-body text-start icon-state">
                                                                <label class="switch">
                                                                    <input id="bootstrap-notify-dismiss"
                                                                        wire:model="allow_dismiss" type="checkbox"><span
                                                                        class="switch-state"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-6 col-form-label">Pause on
                                                            hover</label>
                                                        <div class="col-sm-8 col-6">
                                                            <div class="media-body text-start icon-state">
                                                                <label class="switch">
                                                                    <input id="bootstrap-notify-pause"
                                                                        wire:model="mouse_over" type="checkbox"><span
                                                                        class="switch-state"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-6 col-form-label">Newest on
                                                            top</label>
                                                        <div class="col-sm-8 col-6">
                                                            <div class="media-body text-start icon-state">
                                                                <label class="switch">
                                                                    <input id="bootstrap-notify-top"
                                                                        wire:model="newest_on_top" type="checkbox"><span
                                                                        class="switch-state"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-6 col-form-label">Show
                                                            Progress</label>
                                                        <div class="col-sm-8 col-6">
                                                            <div class="media-body text-start icon-state">
                                                                <label class="switch">
                                                                    <input id="bootstrap-notify-progress"
                                                                        wire:model="showProgressbar"
                                                                        type="checkbox"><span
                                                                        class="switch-state"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 theme-form sm-form">
                                                    <div class="mb-3 row">
                                                        <label class="col-form-label col-lg-3 col-sm-12">Spacing</label>
                                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                                            <input class="form-control digits" wire:model="spacing"
                                                                id="bootstrap-notify-spacing" type="number" value="10">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-form-label col-lg-3 col-sm-12">Delay</label>
                                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                                            <input class="form-control digits" wire:model="delay"
                                                                id="bootstrap-notify-delay" type="number" value="1000">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-form-label col-lg-3 col-sm-12">Timer</label>
                                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                                            <input class="form-control digits" wire:model="timer"
                                                                id="bootstrap-notify-timer" type="number" value="2000">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary btn-air-primary" wire:click="save"
                                        wire:loading.remove>Save</button>
                                    <button class="btn btn-primary btn-air-primary" disabled wire:click="save"
                                        wire:loading wire:target="save">Saving Notification Configuration ...</button>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-danger dark" role="alert">
                                <p class="text-light">No notification setting created yet.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('livewire_third_party')
    <script>
        $(function(){
            Livewire.emit('initializeNotificationSetting');
                    Livewire.on('initialize_notification_setting',function(){
                        IconPicker.Init({
                        jsonUrl: "{{asset('adminetic/assets/js/icon-picker/iconpicker-1.5.0.json')}}",
                        searchPlaceholder: 'Search Icon',
                        showAllButton: 'Show All',
                        cancelButton: 'Cancel',
                        noResultsFound: 'No results found.',
                        borderRadius: '20px',
                        });
                        
                        IconPicker.Run('#iconPicker',function(){
                            var icon = $('#icon').val();
                            @this.set('icon', icon);
                        });
                    });

                    Livewire.on('notification_setting_updated',function(){
                    $.notify({
                               title: "Alert",
                               message:'Notification setting updated',
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