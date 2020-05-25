<?php

namespace gdarko\CDU\Console;

use gdarko\CDU\App;
use Illuminate\Console\Command;

/**
 * Class RecordRemoveCommand
 *
 * @package gdarko\CDU\Console
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class RecordRemoveCommand extends Command
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
    protected $signature = 'remove {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove record from the sync queue';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name  = $this->argument('name');
        $domain = $this->argument('domain');


        $result = $this->app->removeRecord($name, $domain, 'A');

        if(true === $result) {
            $this->info('[SUCCESS] Record removed.');
        } else {
            $this->error('Unable to remove record.');
        }

        return true;
    }

}