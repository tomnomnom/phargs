<?php
// ./Examples/CompoundFlags.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$args = $factory->args();

$args->expectFlag('-H');
$args->expectFlag('-n');
$args->expectFlag('-r');

if ($args->flagIsSet('-H')){
  echo "-H flag is set\n";
}
if ($args->flagIsSet('-n')){
  echo "-n flag is set\n";
}
if ($args->flagIsSet('-r')){
  echo "-r flag is set\n";
}


