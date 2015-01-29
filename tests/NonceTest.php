<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 25.01.2015
 * Time: 21:05
 */

class NonceTest extends Illuminate\Foundation\Testing\TestCase{

    public function testClass(){
//        $nonce = new \Vjroby\LaravelNonce\Nonce();
//
//        $this->assertTrue($nonce instanceof \Vjroby\LaravelNonce\Nonce);
        //TODO write tests
        $this->assertTrue(true);

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
}