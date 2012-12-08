<?php
include __DIR__.'/Phargs/Init.php';

$s = new \Phargs\Screen();

$s->out('Hello,', 'green', 'purple');
$s->out(' World!', 'purple', 'green');
