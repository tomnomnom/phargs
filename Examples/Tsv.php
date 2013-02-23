<?php
// ./Examples/Tsv.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$screen = $factory->screen();

// Get a TSV formatter
$table = $factory->tsv();

$table->setFields(array('id', 'name'));
$table->addRows(array(
  array(1, 'Tom'),
  array(2, 'Dick'),
  array(3, 'Harry'),
));

$screen->out($table);
