<?php

use gdarko\CDU\Console\LoginCommand;
use gdarko\CDU\Console\RecordAddCommand;
use gdarko\CDU\Console\RecordRemoveCommand;
use gdarko\CDU\Console\SyncCommand;
use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

require_once dirname(__FILE__).'/vendor/autoload.php';

$container  = new Container;
$dispatcher = new Dispatcher;
$version    = "7.1.14";

$app = new Application($container, $dispatcher, $version);

$app->add(new LoginCommand());
$app->add(new RecordAddCommand());
$app->add(new RecordRemoveCommand());
$app->add(new SyncCommand());

try {
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage()."\n";
}