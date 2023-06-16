# Notification Module for Adminetic Admin Panel

![Adminetic Notification Module](https://github.com/pratiksh404/adminetic-notify/blob/main/screenshots/banner.jpg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/adminetic/notify.svg?style=flat-square)](https://packagist.org/packages/adminetic/notify)

[![Stars](https://img.shields.io/github/stars/pratiksh404/adminetic-notify)](https://github.com/pratiksh404/adminetic-notify/stargazers) [![Downloads](https://img.shields.io/packagist/dt/adminetic/notify.svg?style=flat-square)](https://packagist.org/packages/adminetic/notify) [![StyleCI](https://github.styleci.io/repos/618407321/shield?branch=main)](https://github.styleci.io/repos/618407321?branch=main) [![License](https://img.shields.io/github/license/pratiksh404/adminetic-notify)](//packagist.org/packages/adminetic/notify)

Notification module for Adminetic Admin Panel

For detailed documentaion visit [Adminetic Notification Module Documentation](https://app.gitbook.com/@pratikdai404/s/adminetic/addons/notify)

#### Contains : -

- Notification Setting Panel
- My Notification Panel
- Notification Bell

## Installation

##### Step 1:

You can install the package via composer:

```bash
composer require adminetic/notify
```

##### Step 2:

Publish database notification migration

```bash
php artisan notification:table
```

##### Step 3:

Migrate notification table.

```bash
php artisan migrate
```

##### Step 4:

Migrate notification table.

```bash
php artisan vendor:publish --tag=notify-config
```

##### Step 5:

Place notification bell component to views/admin/layouts/components/header

```html
  <div class="nav-right col-8 pull-right right-header p-0">
                @livewire('notify.notification-bell')
                {{-- Other Codes --}}
    </div>
```


## Include Adminetic Notification Adapter

In config/adminetic.php, include

```
    // Adapters
    'adapters' => [
        Adminetic\Notify\Adapter\NotifyAdapter::class,
    ],
```



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email pratikdai404@gmail.com instead of using the issue tracker.

## Credits

- [Pratik Shrestha](https://github.com/adminetic)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Screenshots

![Notification Setting](https://github.com/pratiksh404/adminetic-notify/blob/main/screenshots/notification_setting.jpg)
![My Notification](https://github.com/pratiksh404/adminetic-notify/blob/main/screenshots/my_notification.jpg)
![Notification Bell](https://github.com/pratiksh404/adminetic-notify/blob/main/screenshots/notification_bell.jpg)
