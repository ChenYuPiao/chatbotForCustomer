<?php
session_start();
require 'turingRobot.class.php';
$uid =$_SESSION['uid'];
if (isset ($_POST["content"])) {
    $content = $_POST["content"];
}

$test = new TuringRobot('ac33d46c729d4e3ca483d52803d44ef3','35c5d730189f5459');
$res=$test->say($content,$uid);

echo $res;


