<?php

namespace Illuminate\Notifications;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use in7rude\Devino\Client as DevinoClient;

class DevinoChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('devino', function ($app) {
                return new Channels\DevinoSmsChannel(
                    new DevinoClient(
                        $this->app['config']['services.devino.login'],
                        $this->app['config']['services.devino.password']
                    ),
                    $this->app['config']['services.devino.sms_from']
                );
            });
        });
    }
}
