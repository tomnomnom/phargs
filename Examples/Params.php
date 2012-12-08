<?php
// ./Examples/Params.php

// Bootstrap Phargs
include __DIR__.'/../Phargs/Init.php';

// Everything in Phargs is available via the Factory
$factory = new \Phargs\Factory();

// Get an argument processor
$args = $factory->args();

// Expect the --count param
$args->expectParam('--count');

if ($args->paramIsSet('--count')){
  echo "--count param is set\n";
  echo "--count value is: ";
  echo $args->getParamValue('--count').PHP_EOL;
} else {
  echo "--count param is not set\n";
}


