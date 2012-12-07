<?php
include __DIR__.'/Phargs/Init.php';

$o = new \Phargs\Argument\Orchestrator(
  new \Phargs\Argument\Parser(),
  $argv
);

$o->expectFlag('-h', 'Display help');
$o->addFlagAlias('-h', '--help');
$o->expectParam('-f', 'Filename');

var_dump($o->getExpectedFlags());
