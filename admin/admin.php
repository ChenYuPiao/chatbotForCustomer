
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="zh"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="zh"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="zh"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="zh"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>chatbotAdmin</title>
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="../css/default.css">
    <link rel="stylesheet" href="../css/bamboo.css">
    <!--[if IE]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->

</head>
<body>
<div id="console">test</div>

<nav id="main-nav" class="navigation overflow">
    <ul>
        <li><a href="#">管理工具</a></li>
        <li><a href="#">数据查询</a></li>
        <li><a href="#">数据导出</a></li>
        <li><a href="#">数据分析</a></li>

    </ul>
</nav>

<div id="container">

    <header class="primary">
        <span class="open icon">&#9776;</span>
        <hgroup><h1>Chatbot Manager</h1></hgroup>
    </header>
    <section id="scroller" class="overflow">
        <div id="content">
            <header class="htmleaf-header">
                <h2>Bamboo.js</h2>
                <script type="text/javascript">
                    window.onload=function(){
                        var oTab=document.getElementById("tab");
                        var oBt=document.getElementsByTagName("input");
                        oBt[1].onclick=function(){
                            for(var i=0;i<oTab.tBodies[0].rows.length;i++)
                            {
                                var str1=oTab.tBodies[0].rows[i].cells[1].innerHTML.toUpperCase();
                                var str2=oBt[0].value.toUpperCase();
                                //使用string.toUpperCase()(将字符串中的字符全部转换成大写)或string.toLowerCase()(将字符串中的字符全部转换成小写)
                                //所谓忽略大小写的搜索就是将用户输入的字符串全部转换大写或小写，然后把信息表中的字符串的全部转换成大写或小写，最后再去比较两者转换后的字符就行了
                                /*******************************JS实现表格忽略大小写搜索*********************************/
                                if(str1==str2){
                                    oTab.tBodies[0].rows[i].style.background='red';
                                }
                                else{
                                    oTab.tBodies[0].rows[i].style.background='';
                                }
                                /***********************************JS实现表格的模糊搜索*************************************/
                                //表格的模糊搜索的就是通过JS中的一个search()方法，使用格式，string1.search(string2);如果
                                //用户输入的字符串是其一个子串，就会返回该子串在主串的位置，不匹配则会返回-1，故操作如下
                                if(str1.search(str2)!=-1){oTab.tBodies[0].rows[i].style.background='red';}
                                else{oTab.tBodies[0].rows[i].style.background='';}
                                /***********************************JS实现表格的多关键字搜索********************************/
                                //表格的多关键字搜索，加入用户所输入的多个关键字之间用空格隔开，就用split方法把一个长字符串以空格为标准，分成一个字符串数组，
                                //然后以一个循环将切成的数组的子字符串与信息表中的字符串比较
                                var arr=str2.split(' ');
                                for(var j=0;j<arr.length;j++)
                                {
                                    if(str1.search(arr[j])!=-1){oTab.tBodies[0].rows[i].style.background='red';}
                                }
                            }
                        }
                    }
                </script>
            </header>
            <!-- Content goes in here -->
            <input type="text" />
            <input type="button" value="搜索"/>
            <table style='text-align:left;font-size: 10px;' border='1' class="table table-condensed" id="tab">
                <tr><th>id</th><th>问题</th><th>回答</th></tr>
                <?php
                //引用conn.php文件
                require '../db/conn.php';
                //查询数据表中的数据
                $sql = mysqli_query($con,"select * from record");
                $datarow = mysqli_num_rows($sql); //长度
                //循环遍历出数据表中的数据
                for($i=0;$i<$datarow;$i++){
                    $sql_arr = mysqli_fetch_assoc($sql);
                    $id = $sql_arr['uid'];
                   // $name = $sql_arr['na'];
                    $content = $sql_arr['content'];
                    $anwser = $sql_arr['anwser'];
                    echo "<tr><td>$id</td><td>$content</td><td>$anwser</td></tr>";
                }
                ?>
            </table>



            <!-- Content ends -->
        </div>

    </section>



</div>


<!--<script src="http://libs.useso.com/js/jquery/1.11.0/jquery.min.js"></script>-->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
<script src="../lib/jquery-2.2.0.min.js"></script>
<script src="../lib/bamboo.0.1.js"></script>

<script>
    var site = new Bamboo();
</script>
</body>
</html>