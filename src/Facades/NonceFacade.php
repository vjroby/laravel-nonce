<?php
/**
 * Created by PhpStorm.
 * User: Robert Gabriel Dinu
 * Date: 12/18/14
 * Time: 14:08
 */

namespace Vjroby\LaravelNonce\Facades;


use Illuminate\Support\Facades\Facade;

class NonceFacade extends Facade{

    /**
     * Get the registered name of the component
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'vjroby-laravel-nonce';
    }

} // end of class
