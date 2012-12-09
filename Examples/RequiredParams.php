<?php
// ./Examples/RequiredParams.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$args = $factory->args();

// Require some params
$args->requireParam('--count');
$args->requireParam('--number');

// Check that all argument requirements are met
if ($args->requirementsAreMet()){
  echo "All arg requirements are met\n";
} else {
  echo "Not all arg requirements are met\n";
}

