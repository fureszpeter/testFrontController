<?php
namespace TestController\Providers;

use Illuminate\Support\ServiceProvider;
use TestController\Domain\Repositories\UserRepository;
use TestController\Infrastructure\Contracts\Services\EntityIdSetter;
use TestController\Infrastructure\Repositories\MysqlUserRepository;
use TestController\Infrastructure\Services\ReflectionEntityIdSetter;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EntityIdSetter::class, ReflectionEntityIdSetter::class);
        $this->app->bind(UserRepository::class, MysqlUserRepository::class);
    }
}
