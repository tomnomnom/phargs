<?php
include __DIR__.'/Phargs/Init.php';

$s = new \Phargs\Screen();

$s->out($s->colorize('Hello,', 'green', 'purple'));
$s->out($s->colorize(' World!', 'purple', 'green'));
