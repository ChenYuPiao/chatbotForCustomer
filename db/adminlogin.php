<?PHP
session_start();

header("Content-Type: text/html; charset=utf8");
if(!isset($_POST["submit"])){
    exit("错误执行");
}//检测是否有submit操作

include('conn.php');//链接数据库
$name = $_POST['name'];//post获得用户名表单值
$passowrd = $_POST['password'];//post获得用户密码单值

if ($name && $passowrd){//如果用户名和密码都不为空
    $sql = "select * from user where user_name = '$name' and user_pwd='$passowrd'and user_type='1'";//检测数据库是否有对应的username和password的sql
    $result = mysqli_query($con,$sql);//执行sql

    $rows=mysqli_num_rows($result);//返回一个数值

    if($rows){//0 false 1 true
        $s = "select user_id from user where user_name = '$name'";
        $res=mysqli_query($con,$sql);
        $r=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $_SESSION['username']=$name;
        $_SESSION['uid']=$r["user_id"];
        header("refresh:0;url=../admin/admin.html");//如果成功跳转至welcome.html页面
        exit;
    }else{
        echo "用户名或密码错误";
        echo "
                    <script>
                            setTimeout(function(){window.location.href='../admin/sign.html';},1000);
                    </script>

                ";//如果错误使用js 1秒后跳转到登录页面重试;
    }


}else{//如果用户名或密码有空
    echo "表单填写不完整";
    echo "
                      <script>
                            setTimeout(function(){window.location.href='../admin/sign.html';},1000);
                      </script>";

    //如果错误使用js 1秒后跳转到登录页面重试;
}

mysqli_close($con);//关闭数据库