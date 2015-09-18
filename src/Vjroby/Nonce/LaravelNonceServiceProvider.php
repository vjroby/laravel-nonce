<?php namespace Vjroby\LaravelNonce;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Vjroby\LaravelNonce\Storage\NonceDynamoStorage;
use Vjroby\LaravelNonce\Storage\NonceInterface;

class LaravelNonceServiceProvider extends ServiceProvider
{

    const DATABASE_TYPE_MYSQL = 'mysql';
    const DATABASE_TYPE_DYNAMODB = 'dynamodb';
    const DEFAULT_DYNAMODB_TABLE_NAME = 'nonces';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->package('vjroby/laravel-nonce', 'vjroby-laravel-nonce');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO change the database connection from the config

        $this->app->bind('vjroby-laravel-nonce', function ($app) {

            return $this->getNonceObjectByDatabaseType();
        });

        $this->registerCommands();
    }

    /**
     * Registers some utility commands with artisan
     * @return void
     */
    public function registerCommands()
    {
        $this->app->bind('command.vjroby-laravel-nonce.migrations', 'Vjroby\LaravelNonce\Console\MigrationsCommand');
        $this->commands('command.vjroby-laravel-nonce.migrations');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['vjroby-laravel-nonce'];
    }

    /**
     * @return NonceInterface
     */
    private function getNonceObjectByDatabaseType()
    {

        switch (Config::get('nonce.database_type')) {

            case self::DATABASE_TYPE_DYNAMODB:
                if (isset($this->client)){
                    return $this->client;
                }
                $dynamoDbDomain = App::make('aws')->get('DynamoDb');

                $client = DynamoDbClient::factory([
                    'credentials' => $dynamoDbDomain->getCredentials(),
                    'region' => Config::get('nonce.dynamodb_table_name')
                ]);

                $nonceDynamo = new NonceDynamoStorage();
                $nonceDynamo->setClient($client);
                $nonceDynamo->setTableName(Config::get('nonce.dynamodb_table_name'));
                return new NonceDynamoStorage();
                break;

            case self::DATABASE_TYPE_MYSQL:
                return new Nonce();
                break;

            default:
                return new Nonce();
                break;
        }
    }

}
