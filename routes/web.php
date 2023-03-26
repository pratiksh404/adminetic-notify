<?php

use Illuminate\Support\Facades\Route;

// Notification Routes
Route::view('my-notification', 'notify::admin.notification.my_notification')->name('my_notification');
Route::get('my-notification/{id}', function ($id) {
    return view('notify::admin.notification.my_notification', compact('id'));
})->name('show_notification');

// Notification
Route::view('notification-setting', 'notify::admin.notification.notification_setting')->name('notification_setting');
