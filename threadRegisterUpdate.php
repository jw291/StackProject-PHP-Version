<?php
session_start();

$host ="localhost";
$user ="root";
$pass ="digh1221";

//회원가입시 입력하는 아이디, 비밀번호, 이메일 값들을 변수에 저장한다.
$user_introduce = $_POST['user_introduce'];
$user_motive = $_POST['user_motive'];
$user_major = $_POST['user_major'];
$user_idnumber = $_POST['user_idnumber'];
$user_name = $_SESSION['user_name'];


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

if(isset($_POST['bno'])){
$bno = $_POST['bno'];
}

//홍보 게시판에 올린 스레드 이름 가져오기
$sql = "select threadname, b_title, b_content, b_date, b_hit, b_id from board_advertisement where b_no= ".$bno;
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
$threadname = $row['threadname'];

//홍보 게시판에 올린 사람(=마스터)이름 가져오기

$sql = "select t_master from thread where threadname = '$threadname'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
$mastername = $row['t_master'];

//아이디가 존재하지 않다면 넣겟다. POST로 전달받은 값을
$sql3 = "INSERT INTO thread(t_no, threadname, t_user, t_master) VALUE(null,'{$threadname}','{$user_name}','$row[t_master]')";
$ret = mysqli_query($mysqli,$sql3);

$sql4 = "UPDATE user SET jointhreadname = '$threadname' WHERE user_id = '$_SESSION[user_id]'";
$ret4 = mysqli_query($mysqli,$sql4);

$sql5 = "UPDATE session SET jointhreadname = '$threadname' WHERE user_id = '$_SESSION[user_id]'";
$ret5 = mysqli_query($mysqli,$sql5);

//True or False 반환
if($ret5){
echo "<script> alert('스레드 가입이 완료되었습니다.');</script>";
echo "<meta http-equiv='refresh'content=\"0;url='home.php'\">";
exit(0);
}else{
 die('mysql query error :'.mysql_error());
}

?>
