<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 25.01.2015
 * Time: 21:05
 */

class NonceTest extends TestCase{

    public function testClass(){
        $nonce = new \Vjroby\LaravelNonce\Nonce();

        $this->assertTrue($nonce instanceof \Vjroby\LaravelNonce\Nonce);
    }
}