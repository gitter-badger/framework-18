<?php
namespace Viserio\Http\Providers;

use Viserio\Application\ServiceProvider;
use Viserio\Http\Response;

/**
 * ResponseServiceProvider.
 *
 * @author  Daniel Bannert
 *
 * @since   0.8.0
 */
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('response', function () {
            return new Response();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'response',
        ];
    }
}
