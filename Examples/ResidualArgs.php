<?php
// ./Examples/ResidualArgs.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$args = $factory->args();

// We're expecting some arguments
$args->expectParam('--count');
$args->expectFlag('-h');

// Arguments we're not expecting are considered 'residual'
echo "Residual arg #0: ".$args->getResidualArg(0).PHP_EOL;
echo "All residual args: ".implode(', ', $args->getResidualArgs()).PHP_EOL;
echo "First two residual args: ".implode(', ', $args->getResidualArgs(0, 2)).PHP_EOL;


