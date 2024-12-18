<?php

namespace FikriMastor\AuditLogin\Tests;

use FikriMastor\AuditLogin\AuditLoginServiceProvider;
use FikriMastor\AuditLogin\Tests\TestModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'FikriMastor\\AuditLogin\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AuditLoginServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //config()->set('database.default', 'testing');
        //dd(database_path('database.sqlite'));
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Use test User model for users provider
        $app['config']->set('auth.providers.users.model', User::class);

        //        $migration = include __DIR__.'/../database/migrations/create_audit_logins_table.php.stub';
        //        $migration->up();
    }
}
