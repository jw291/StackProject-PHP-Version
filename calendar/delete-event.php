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

$id = $_POST['id'];
$sqlDelete = "DELETE from tbl_events WHERE id=".$id;

mysqli_query($mysqli, $sqlDelete);
echo mysqli_affected_rows($mysqli);

mysqli_close($mysqli);
?>
