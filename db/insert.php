<?php

header("Content-Type: text/html; charset=utf8");

    if(!isset($_POST['submit'])){
        exit("错误执行");
    }//判断是否有submit操作

    $name=$_POST['name'];//post获取表单里的name
    $email=$_POST['email'];
    $sex=$_POST['sex'];
    $age=$_POST['age'];
    $password=$_POST['password'];

//连接数据库
include('../db/conn.php');
$sql="insert into user(user_id,user_name,user_email,user_sex,user_age,user_pwd,user_type) values (null,'$name','$email','$sex','$age','$password','0')";
$reslut=mysqli_query($con,$sql);//执行sql
    
    if (!$reslut){
        die("error:".mysqli_error($con));//如果sql执行失败输出错误
    }else{
        echo "注册成功";//成功输出注册成功
    }

    

    mysqli_close($con);//关闭数据库
