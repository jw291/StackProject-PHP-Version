<?php
session_start();
$host ="localhost";
$user ="root";
$pass ="digh1221";
//연동 확인
$mysqli = new mysqli($host,$user,$pass);
if(!$mysqli){
	die('MySQL connect ERROR:'.mysql_error());
}
//데이터 베이스 진입
$ret = mysqli_select_db($mysqli,'stack');
if(!$ret){
	die('db connect error:'.mysql_error());
}

    $json = array();
    $sqlQuery = "SELECT id, title, start, end FROM tbl_events where threadname = '$_SESSION[jointhreadname]' ORDER BY ID";
    $result = mysqli_query($mysqli, $sqlQuery);
    $eventArray = array();
    
	while ($row = mysqli_fetch_assoc($result)) {
        	array_push($eventArray, $row);
 	}
    mysqli_free_result($result);
   
    mysqli_close($mysqli);
    echo json_encode($eventArray);

?>
