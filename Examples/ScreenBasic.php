<?php
// ./Examples/ScreenBasic.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();

// Get a screen interface
$screen = $factory->screen();

$screen->out("Hello, ");
$screen->outln("World!");

$screen->err("Error ");
$screen->errln("message");

$screen->printf("When in %s".PHP_EOL, "Rome");

$testVar = array(1, 2, 3);
$screen->varExport($testVar);

$screen->log('A log message');
