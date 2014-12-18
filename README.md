Laravel package for using nonces.

Instalation:

add to app providers:

'Vjroby\LaravelNonce\LaravelNonceServiceProvider'

and to aliases:

'Nonce'			=> 'Vjroby\Facade\NonceFacade',

so it can be used static.

For creating the table:

php artisan vjroby-laravel-nonce:migrations

it creates 2014_12_18_133440_create_nonce_table migration

and then:

php artisan migrate
