<?php
// ./Examples/ParamAliases.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$args = $factory->args();

// Expect the --count param
$args->expectParam('--count');

// Alias --count to -c so that either can be used
$args->addParamAlias('--count', '-c');

if ($args->paramIsSet('--count')){
  echo "--count param is set\n";
  echo "--count value is: ";
  echo $args->getParamValue('-c');
} else {
  echo "--count param is not set\n";
}


