<?php

namespace gdarko\CDU\Console;

use gdarko\CDU\App;
use Illuminate\Console\Command;

/**
 * Class SyncCommand
 *
 * @package gdarko\CDU\Console
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class SyncCommand extends Command
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
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the added domains to Cloudflare. This command can be invoked periodically from cron.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $total = $this->app->sync();

        if ($total) {
            $this->info('[SUCCESS] Sync successful! '.$total.' domains synced.');
        } else {
            $this->error('Unable to sync domains.');
        }

        return true;
    }

}