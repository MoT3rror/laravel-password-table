<?php
class MD5HashServiceProvider extends Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app['hash'] = $this->app->share(function () {
            return new MD5Hasher();
        });
    }

    public function provides() 
    {
        return array('hash');
    }
}
