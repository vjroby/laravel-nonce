<?php

use Aws\Common\Aws;
use Illuminate\Support\Facades\App;
use Mockery as m;
use Mockery\MockInterface;

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

        $this->app['config']->set('nonce.database_type', $this->databaseType);
        $this->app['config']->set('nonce.dynamodb_table_name', $this->dynamoDBtableName);
        $this->app['config']->set('nonce.dynamodb_table_region', $this->dynamoRegion);

        $this->mockAws();
    }

    protected function mockAws()
    {
        $credentialsTestArray = ['credentials' => 'test'];
        $this->serviceBuilder = Aws::factory();
        $this->serviceBuilder->enableFacades();

        $this->mockAws = m::mock('Awx');
        $this->dynamoDbClient = m::mock('DynamoDbClient');
        App::shouldReceive('make')->with('aws')->once()->andReturn($this->dynamoDbClient);
        $this->dynamoDbClient->shouldReceive('get')->once()->with('DynamoDb')
            ->andReturnSelf();
        $this->dynamoDbClient->shouldReceive('getCredentials')->once()->andReturn($credentialsTestArray);



        \Aws\DynamoDb\DynamoDbClient::shouldReceive('factory')->once();
    }

    public function testCheckNonce()
    {
        $token = 'testtoken';
        $data = 'test data';
        $this->dynamoDbClient->shouldReceive('getItem')->once();

        \Nonce::checkNonce($token, $data);

    }

} // end of class