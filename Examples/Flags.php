<?php
// ./Examples/Flags.php

// Bootstrap Phargs
include __DIR__.'/../Phargs/Init.php';

// Everything in Phargs is available via the Factory
$factory = new \Phargs\Factory();

// Get an argument processor
$args = $factory->args();

// Expect the -h flag to be an argument
$args->expectFlag('-h');

if ($args->flagIsSet('-h')){
  echo "Help flag is set\n";
} else {
  echo "Help flag is not set\n";
}


