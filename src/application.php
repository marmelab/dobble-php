#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use Dobble\DobbleCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new DobbleCommand());
$app->run();
