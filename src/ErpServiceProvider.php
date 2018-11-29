<?php

namespace ErpConnect;

use Illuminate\Support\ServiceProvider;

class ErpServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = false; // 延迟加载服务


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('erpconnect', function ($app) {
            return new ErpConnect($app['config']);
        });
    }


    public function provides()
    {
        return ['erpconnect'];
    }
}
