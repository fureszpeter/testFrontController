<?php
namespace TestController\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use PDO;

class MysqlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PDO::class,
            function () {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s',
                    Config::get('database.connections.mysql.host'),
                    Config::get('database.connections.mysql.database')
                );

                return new PDO(
                    $dsn,
                    Config::get('database.connections.mysql.username'),
                    Config::get('database.connections.mysql.password')
                );
            }
        );
    }
}
