@extends(request()->header('layout') ?? 'adminetic::admin.layouts.app')

@section('content')
@livewire('notify.my-notification',['given_id' => $id ?? null])
@endsection