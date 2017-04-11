<?php
require 'vendor/autoload.php';
require 'turingRobot.class.php';

$test = new TuringRobot('ac33d46c729d4e3ca483d52803d44ef3','35c5d730189f5459');

echo $test->say('hello');
