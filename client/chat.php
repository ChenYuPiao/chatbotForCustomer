<?php

session_start();
require '../vendor/autoload.php';
require 'turingRobot.class.php';

$test = new TuringRobot('ac33d46c729d4e3ca483d52803d44ef3','35c5d730189f5459');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../lib/Font-Awesome-3.2.1/css/font-awesome.min.css">
    <title>Document</title>
    <script>
        var uid = '<?php echo $_SESSION['uid'] ?>';
        $(function () {
            function bottom() {
                var div = document.getElementById("chatshow");
                div.scrollTop = div.scrollHeight;
            }

            $("#post").click(function () {
                postMsg();
                
            });
            $(document).keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    postMsg();
                }
            });
            function postMsg() {
                var content = $("#content").val();
                var res=<?php $test->say('$content',uid); ?>;
                var obj=JSON.parse(res);
                if (!$.trim(content)) {
                    alert('请填写内容');
                    return false;
                }
                $("#content").val("");
                
                
                    if(res){
                        
                        var chatbotres = '';
                        $.each(obj, function (key, val) {
                            chatbotres += "<li class='left'>" + "小图" + "：" + val['content'] + "</li>";
                        }
                    }
                
                $("#chatshow").html(chatbotres);
                bottom();
            }
                $.post("ajax.php", {content: content,anwser:obj.content});

            $(".close").click(function () {
                if (confirm("您确定要关闭本页吗？")) {
                    window.location.reload();
                    session_destroy();
                }
            });
            /*function getData(msg) {
                $.post("get.php", {"msg": msg}, function (data) {
                    if (data) {
                        var chatcontent = '';
                        var obj = JSON.parse(data);
                        $.each(obj, function (key, val) {
                            if (val['uid'] == uid) {
                                chatcontent += "<li class='right'>" + val['content'] + "</li>";
                            } else {
                                chatcontent += "<li class='left'>" + val['username'] + "：" + val['content'] + "</li>";
                            }
                        });
                        $("#chatshow").html(chatcontent);
                        bottom();
                    }
                    
                });
            }

            getData("one");
*/

            $("#userlist p").click(function () {
                $("#content").val("@" + $(this).text() + " ");
            });
        });


    </script>
</head>
<body>
   <div class="container main">
       <div class="page-header">
        <h1>A Chatbot For Customer</h1>
       </div>
        <div id="userlist">
        <h1>当前用户</h1>
        <div>
            <?php
                echo '<p>'.$_SESSION['username'].'</p>';
            ?>
        </div>
    </div>
    <div class="message">
        <span class="close""></span>
        <ul class="chat-thread" id="chatshow">
            <li class=right>小图：你好啊，请问有什么需要帮助的嘛</li>
        </ul>
        <div style="margin-top: 20px;">
            <textarea name="content" id="content"></textarea>
        </div>
        <span id="post">发布</span>
    </div>
</div>
    </div>
</div>
<footer>
        <p align="center">
            Copyright &copy;2017 Chatbot by Chenyupiao
        </p>
</footer>
    <script src="lib/jquery-2.2.0.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    
</body>
</html>