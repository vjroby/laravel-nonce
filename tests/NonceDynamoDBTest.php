<?php

use Aws\Common\Aws;
use Illuminate\Support\Facades\App;
use Mockery as m;
use Mockery\MockInterface;
use Aws\Laravel\AwsFacade as AWSFacade;

class NonceDynamoDBTest extends Illuminate\Foundation\Testing\TestCase
{
    protected $databaseType = 'dynamodb';
    protected $dynamoDBtableName = 'nonces';
    protected $dynamoRegion = 'us-west-2';

    private $serviceBuilder;
    /**
     * @var MockInterface
     */
    private $mockAws;
    /**
     * @var MockInterface
     */
    private $dynamoDbClient;

    public function tearDown()
    {
        m::close();
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        $app = require __DIR__ . '/bootstrap/start.php';

        $app->register('Vjroby\LaravelNonce\LaravelNonceServiceProvider');

//        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('vjroby-laravel-nonce::database_type', $this->databaseType);
        $this->app['config']->set('vjroby-laravel-nonce::dynamodb_table_name', $this->dynamoDBtableName);
        $this->app['config']->set('vjroby-laravel-nonc::.dynamodb_table_region', $this->dynamoRegion);

        $this->mockAws();
    }

    protected function mockAws()
    {
        $credentialsTestArray = ['credentials' => 'test'];
//        $this->serviceBuilder = Aws::factory();
//        $this->serviceBuilder->enableFacades();

//        AWSFacade::setFacadeApplication($this->app);

        $this->mockAws = m::mock('Aws');
        $this->dynamoDbClient = m::mock('DynamoDbClient');
        App::shouldReceive('make')->with('aws')->once()->andReturn($this->dynamoDbClient);
        $this->dynamoDbClient->shouldReceive('get')->once()->with('DynamoDb')
            ->andReturnSelf();
        $this->dynamoDbClient->shouldReceive('getCredentials')->once()->andReturn($credentialsTestArray);

    }

    public function testCheckNonceWithNonceNotFound()
    {
        $token = 'testtoken';
        $data = 'test data';
        $response = m::mock('Model');
        $this->dynamoDbClient->shouldReceive('getItem')
            ->once()
            ->with([
                'TableName' => $this->dynamoDBtableName,
                'Key' => [
                    'token' => [
                        'S' => $token
                    ]
                ],
                'ConsistentRead' => true
            ])
            ->andReturn($response);
        $response->shouldReceive('get')->once()->andReturnNull();

        $nonceDynamoStorage = $this->app['vjroby-laravel-nonce'];
        $nonceDynamoStorage->setClient($this->dynamoDbClient);
        $nullNounce = $nonceDynamoStorage->checkNonce($token, $data);
        $this->assertTrue($nullNounce);
    }

    public function testCheckNonceWithNonceFound()
    {
        $token = 'testtoken';
        $data = 'test data';
        $response = m::mock('Model');
        $this->dynamoDbClient->shouldReceive('getItem')
            ->once()
            ->with([
                'TableName' => $this->dynamoDBtableName,
                'Key' => [
                    'token' => [
                        'S' => $token
                    ]
                ],
                'ConsistentRead' => true
            ])
            ->andReturn($response);
        $response->shouldReceive('get')->with('Item')->once()->andReturn('item');

        $nonceDynamoStorage = $this->app['vjroby-laravel-nonce'];
        $nonceDynamoStorage->setClient($this->dynamoDbClient);
        $nullNounce = $nonceDynamoStorage->checkNonce($token, $data);
        $this->assertFalse($nullNounce);
    }

    public function testSetNonceWithData()
    {
        $token = 'token set';
        $data = 'set data';
        $this->dynamoDbClient->shouldReceive('putItem')->once();
        $nonceDynamoStorage = $this->app['vjroby-laravel-nonce'];
        $nonceDynamoStorage->setClient($this->dynamoDbClient);
        $nonceDynamoStorage->setNonce($token, $data);
    }

} // end of class