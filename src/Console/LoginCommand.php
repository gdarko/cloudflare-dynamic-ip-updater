<?php

namespace gdarko\CDU\Console;

use gdarko\CDU\App;
use Illuminate\Console\Command;

/**
 * Class LoginCommand
 *
 * @package gdarko\CDU\Console
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class LoginCommand extends Command
{
    /**
     * @var App
     */
    protected $app;

    /**
     * LoginCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->app = new App();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login {email} {apikey}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authenticate to CloudFlare with your api key and email';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email  = $this->argument('email');
        $apikey = $this->argument('apikey');

        $uid = $this->app->login($email, $apikey);

        if (false === $uid) {
            $this->error('Argh... Invalid email or api key.');
        } else {
            $this->app->storeCredentials($email, $apikey);
            $this->info('[SUCCESS] Login successful. You can now use other commands that require login.');
        }
        return true;
    }

}