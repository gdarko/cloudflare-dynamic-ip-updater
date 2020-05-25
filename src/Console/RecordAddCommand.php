<?php

namespace gdarko\CDU\Console;

use gdarko\CDU\App;
use Illuminate\Console\Command;

/**
 * Class RecordAddCommand
 *
 * @package gdarko\CDU\Console
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class RecordAddCommand extends Command
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
    protected $signature = 'add {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add record to the sync queue';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name   = $this->argument('name');
        $domain = $this->argument('domain');
        $result = $this->app->addRecord($name, $domain, 'A');

        if (true === $result) {
            $this->info('[SUCCESS] Record added.');
        } else {
            $this->error('Unable to add record.');
        }


        return true;
    }

}