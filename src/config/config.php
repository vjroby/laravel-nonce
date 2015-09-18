<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Database Connection to use
    |--------------------------------------------------------------------------
    |
    | Set the default database connection to use for the repositories,
    | when set to default, it uses whatever connection you specified in your laravel db config.
    |
    */
    'database' => 'default',

     /*
    |--------------------------------------------------------------------------
    | Database Type
    |--------------------------------------------------------------------------
    |
    | The package supports mysql and DynamoDB (AWS NoSQL)
    |
    |     'database_type' => 'dynamodb',
    */
    'database_type' => 'mysql',
     /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    |
    | The package supports mysql and DynamoDB (AWS NoSQL)
    |
    |
    */
    'database_connection' => 'mysql',


    /*
  |--------------------------------------------------------------------------
  | DynamoDB table name
  |--------------------------------------------------------------------------
  |
  | The package supports mysql and DynamoDB (AWS NoSQL)
  |
  |     'database_type' => 'dynamodb',
  */

    'dynamodb_table_name' => 'nonces',
    /*
  |--------------------------------------------------------------------------
  | DynamoDB table name
  |--------------------------------------------------------------------------
  |
  | The package supports mysql and DynamoDB (AWS NoSQL)
  |
  |     'database_type' => 'dynamodb',
  */

    'dynamodb_table_region' => 'us-west-2',
];