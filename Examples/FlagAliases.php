<?php
// ./Examples/FlagAliases.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$args = $factory->args();

$args->expectFlag('-h');

// Alias the -h flag to --help so either can be used
$args->addFlagAlias('-h', '--help');

// You could check for --help instead of -h here and it would still work
if ($args->flagIsSet('-h')){
  echo "Help flag is set\n";
} else {
  echo "Help flag is not set\n";
}


