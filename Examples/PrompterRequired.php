<?php
// ./Examples/PrompterRequired.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();
$screen = $factory->screen();

// Get a prompter
$prompter = $factory->prompter();

// Prompt for some required input
$name = $prompter->promptRequired('What is your name? ', 'No name entered!');

// Do something with the response
$screen->outln("Hello, {$name}!");

