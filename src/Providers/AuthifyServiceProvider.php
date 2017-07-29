<?php
/**
 * Demo Helper Service Provider File.
 *
 * @author   Oliver Green <oliver@c5labs.com>
 * @license  See attached license file
 */
namespace Concrete\Package\FacebookFeed\Src\Providers;

use BoxedCode\Authify\Manager;
use BoxedCode\Authify\Providers\Manager as ProviderManager;
use BoxedCode\Authify\Stores\ConcreteConfigStore;
use BoxedCode\Authify\Stores\SessionStore;
use Concrete\Core\Foundation\Service\Provider;
use Core;
use Events;
use View;
use Database;
use Log;
use URL;
use Exception;

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * Demo Helper Service Provider.
 */
class AuthifyServiceProvider extends Provider
{
    public function register()
    {
        $configurationRepository = Core::make(
            \Concrete\Core\Config\Repository\Repository::class
        );

        $this->app->singleton('authify.factory', function () {
            $sessionStore = new SessionStore();
            return new ProviderManager($sessionStore);
        });

        $this->app->singleton('authify.configuration', function () use ($configurationRepository) {
            return new ConcreteConfigStore(
                'concrete.authify.configuration', $configurationRepository
            );
        });

        $this->app->singleton('authify.manager', function () use ($configurationRepository) {
            $credentialsStore = new ConcreteConfigStore(
                'concrete.authify.credentials', $configurationRepository
            );

            return new Manager(
                $this->app->make('authify.configuration'),
                $credentialsStore,
                $this->app->make('authify.factory')
            );
        });

    }

    public function boot()
    {
        // Code included here will be executed after all service providers have been 
        // registered and the CMS is booting.
    }
}
