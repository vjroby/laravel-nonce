<?php

use Illuminate\Filesystem\Filesystem;
use Mockery as m;

class NonceTest extends Illuminate\Foundation\Testing\TestCase{

    public function tearDown()
    {
        m::close();
    }

    public function testWithDatabase(){
        $nonce = new \Vjroby\LaravelNonce\Nonce();

        $nonceId = uniqid();

        $nonce->setNonce($nonceId, '');

        $nonce = DB::table('nonce')->where('id', $nonceId)->get();

        $this->assertTrue(count($nonce) == 1);

        $this->assertEquals($nonceId, $nonce[0]->id);

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

        $app = require __DIR__.'/bootstrap/start.php';

        $app->register('Vjroby\LaravelNonce\LaravelNonceServiceProvider');

//        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'testing');

        $a = __DIR__.'/../src/migrations';

        $this->app['config']->set('database.connections.testing', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));

        $this->migrate();
    }

    public function migrate()
    {

        Schema::dropIfExists('nonce');



        Schema::create('nonce', function(\Illuminate\Database\Schema\Blueprint $table){
            $table->string('id',255);
            $table->string('data',255)->nullable();
            $table->nullableTimestamps();

            $table->unique(['id', 'data']);
            $table->index(['id', 'data']);
        });

//
//        $fileSystem = new Filesystem;
////        $classFinder = new ClassFinder;
//
//        foreach($fileSystem->files(__DIR__ . "/../src/migrations") as $file)
//        {
//            $fileSystem->requireOnce($file);
//            $migrationClass = new CreateNonceTable();
//
//            $migrationClass->up();
//        }
    }


}