<?php
// ./Examples/ScreenColors.php

include __DIR__.'/../Phargs/Init.php';
$factory = new \Phargs\Factory();

// Get a screen interface
$screen = $factory->screen();

$screen->outln("Red", 'red');

$screen->outln("Red with a white background", "red", "white");

$screen->outln("Red with a white background, underlined", "red", "white", "underline");

