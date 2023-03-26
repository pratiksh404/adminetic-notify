<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('push_notification', function () {
    return true;
});

Broadcast::channel('general_push_notification', function () {
    return true;
});
