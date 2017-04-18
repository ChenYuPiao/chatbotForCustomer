
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
                <div class="htmleaf-links">

                </div>
            </header>
            <!-- Content goes in here -->
            <table style='text-align:left;' border='1'>
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
<script src="../lib/jquery-2.2.0.min.js"></script>
<script src="../lib/bamboo.0.1.js"></script>

<script>
    var site = new Bamboo();
</script>
</body>
</html>