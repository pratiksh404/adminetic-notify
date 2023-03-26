@extends(request()->header('layout') ?? 'adminetic::admin.layouts.app')

@section('content')
<div class="container-fluid">
    @livewire('notify.notification-setting')
</div>
@endsection