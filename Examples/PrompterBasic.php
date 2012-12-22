<?php
// ./Examples/PrompterBasic.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$screen = $factory->screen();

// Get a prompter
$prompter = $factory->prompter();

// Prompt for some input
$name = $prompter->prompt('What is your name? ');

// Do something with the response
$screen->outln("Hello, {$name}!");

