<?php
/**
 * 服务端模拟数据
 */

//前端期望数据为json
header("Content-Type:application/json;charset=utf-8");
//post 请求 请求内容类型为 application/x-www-form-urlencoded 如果是 application/json 则需要另行处理 $_POST 数组不会被填充

//为了保持模拟的数据
session_start();

/*if ($_SESSION['emulate_data']) {
    //已生成
} else {*/
    $list = [];
    require "../db/conn.php";
    $sql="select uid,uname, content,anwser from record";
    $res=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($res)){
        $list[]=[
          "uid" => $row['uid'],
            "uname" => $row['uname'],
            "content" => $row['content'],
            "anwser" => $row['anwser']
        ];
    }


    $_SESSION['emulate_data'] = $list;


$list_temp = [];
//检索
if (isset($_POST['search']) && !empty($_POST['search'])) {
    foreach ($_SESSION['emulate_data'] as $key => $row) {
        if (strpos($row['uname'], $_POST['search']) !== false
            || strpos($row['content'], $_POST['search']) !== false) {
            $list_temp[] = $_SESSION['emulate_data'][$key];
        }
    }
} else {
    $list_temp = $_SESSION['emulate_data'];
}
//排序
if (isset($_POST['sort'])) {
    $temp = [];
    foreach ($list_temp as $row) {
        $temp[] = $row[$_POST['sort']];
    }
    //php的多维排序
    array_multisort($temp,
        $_POST['sort'] == 'uname' ? SORT_STRING : SORT_NUMERIC,
        $_POST['order'] == 'asc' ? SORT_ASC : SORT_DESC,
        $list_temp
    );
}

//分页时需要获取记录总数，键值为 total
$result["total"] = count($list_temp);
//根据传递过来的分页偏移量和分页量截取模拟分页 rows 可以根据前端的 dataField 来设置
$result["rows"] = array_slice($list_temp, $_POST['offset'], $_POST['limit']);

echo json_encode($result);