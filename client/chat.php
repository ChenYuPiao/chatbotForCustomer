<?php
/**
 ** @author chenyupiao
 ** @blog http://chenyupiao.com
 ** @email onlycyp@163.com
 ** @version chatbotforcudtomer 0.1v
 */
session_start();
require '../vendor/autoload.php';
require 'turingRobot.class.php';
include('../db/conn.php');

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
    <script src="../lib/jquery-2.2.0.min.js"></script>
    <title>Document</title>
    <script type="text/javascript">
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
                if (!$.trim(content)) {
                    alert('请填写内容');
                    return false;
                }
                var res=null;
                var chatto='';
                chatto += "<li class='right'>" + content + "</li>";
                $("#chatshow").append(chatto);
                bottom();
                $("#content").val("");
                $.post("content.php",{"content": content},function (data) {
                    if(data){
                        res=data;
                        var chatbotres = '';
                        //alert(res.text+res.code);
                        switch (res.code){
                            case 100000:
                                chatbotres += "<li class='left'>" + "Miumiu" + "：" + res.text + "</li>";
                                $.post("ajax.php", {content: content,anwser:res.text});
                                $("#chatshow").append(chatbotres);
                                break;
                            case 200000:
                                chatbotres += "<li class='left'>" + "Miumiu" + "：" + res.text + ":" + "<a href=\" " + res.url + "\" target='_blank'>" +"打开页面" + "</a>"+"</li>";
                                $.post("ajax.php", {content: content,anwser:res.text+res.url});
                                $("#chatshow").append(chatbotres);
                                break;
                            case 302000:
                                chatbotres += "<li class='left'>" + "Miumiu" +  "<a href= \" " + res.list[0]['detailurl'] + "\" target='_blank'>" + ":" + res.list[0]['article'] + "</a>" + "</li>";
                                $("#chatshow").append(chatbotres);
                                $.post("ajax.php", {content: content,anwser:res.list[0]['article']+res.list[0]['detailurl']});
                                chatbotres += "<li class='left'>" + "Miumiu" +  "<a href=\"" + res.list[1]['detailurl'] + "\" target='_blank'>" + ":" + res.list[1]['article'] + "</a>" + "</li>";
                                $("#chatshow").append(chatbotres);
                                $.post("ajax.php", {content: content,anwser:res.list[1]['article']+res.list[1]['detailurl']});
                                break;
                            case 308000:
                                chatbotres += "<li class='left'>" + "Miumiu" +  "<a href=\"" + res.list[0]['detailurl'] + "\" target='_blank'>" + ":" + res.list[0]['name'] + "-" + res.list[0]['info'] + "</a>" + "</li>";
                                $("#chatshow").append(chatbotres);
                                $.post("ajax.php", {content: content,anwser:res.list[0]['name']+res.list[0]['info']+res.list[0]['detailurl']});
                                break;



                        }


                            /*chatbotres += "<li class='left'>" + "小图" + "：" + res.text + "</li>";
                            $.post("ajax.php", {content: content,anwser:res.text});

                        $("#chatshow").append(chatbotres);*/
                        bottom();
                    }

                },"json");


            }


            $(".close").click(function () {
                if (confirm("您确定要关闭本页吗？")) {
                    window.location.reload();
                    //session_destroy();
                }
            });


            $("#userlist p").click(function () {
                $("#content").val("@" + $(this).text() + " ");
            });
        });


    </script>
</head>
<body>
   <div class="container main">
       <div class="page-header" style="color: white">
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
            <li class=left>Miumiu：你好啊，请问有什么需要帮助的嘛</li>
        </ul>
        <!--<div class="chat-thread" id="chatnews">

        </div>-->
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
    <script src="../lib/jquery-2.2.0.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
    
</body>
</html>