<?php

session_start();
/*if (isset($_POST['content'])) {
    $filename = "log/" . date("Ymd", time()) . ".txt";
    $con = array(
        'username' => $_SESSION["username"],
        'uid' => $_SESSION["uid"],
        'content' => $_POST["content"]
    );
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        $data = json_decode($content, true);
    }
    $file = fopen($filename, "w");
    $data[] = $con;
    fwrite($file, json_encode($data));
    fclose($file);
}*/


/****数据库方式
****/
include('../db/conn.php');
session_start();
if (isset($_POST['content'])&&($_POST['anwser'])) {
    $content = $_POST['content'];
    $anwser = $_POST['anwser'];
    $sql = "INSERT INTO record (content,uid,anwser) VALUES ('{$content}','{$_SESSION['uid']}','{$anwser}');";
    $res = mysqli_query($con, $sql);
}

