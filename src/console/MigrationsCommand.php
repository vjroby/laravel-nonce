<?php
/**
 * Created by PhpStorm.
 * User: Robert Gabriel Dinu
 * Date: 12/18/14
 * Time: 15:00
 */

namespace Vjroby\LaravelNonce\Console;


use Illuminate\Console\Command;

class MigrationsCommand extends Command{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vjroby-laravel-nonce:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the migrations needed for Laravel Nonce package';

    /**
     * Create a new reminder table command instance.
     *
     * @return \Vjroby\LaravelNonce\Console\MigrationsCommand
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->call('migrate:publish', ['package' => 'vjroby/vjroby-laravel-nonce']);
        $this->call('dump-autoload');
    }

} // end of class