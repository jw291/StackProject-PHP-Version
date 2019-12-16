<?php
$host ="localhost";
$user ="root";
$pass ="digh1221";
//mysql접속
$db = new mysqli($host,$user,$pass);
if(!$db){
die('MySQL connect ERROR:'.mysql_error());
}

//데이터 베이스 진입
$ret = mysqli_select_db($db,'stack');
if(!$ret){
	die('db connect error:'.mysql_error());
}

//해당 페이지에서 세션을 이용하겠다.
session_start();

//로그인한 사용자의 아이디는 세션의 user_id로 저장되어 있다.
$user_id = $_SESSION['user_id'];
//해당 유저명에 해당하는 세션 데이터를 삭제하는 쿼리문
$sql="DELETE FROM session WHERE user_id='{$user_id}'";
$ret=mysqli_query($db,$sql);

//쿠키 초기화
setcookie(session_name(),'',time()-99999999999);
//세션 파괴
session_destroy();
if($ret){
	echo"<script>('로그아웃 성공');</script>";
}else{
	echo"<script>('로그아웃 실패');</script>";
}
?>
<meta http-equiv='refresh'content="0;url='./home.php">
