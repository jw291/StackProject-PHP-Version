<?php
//회원가입시 입력하는 아이디, 비밀번호, 이메일 값들을 변수에 저장한다.
$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_pw = $_POST['user_pw'];
$user_pw_question = $_POST['find_account_question'];
$user_pw_answer = $_POST['find_account_answer'];

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
	//아이디가 존재하지 않다면 넣겟다. POST로 전달받은 값을
	$sql = "INSERT INTO user(user_id, user_name, user_email,user_pw,user_pw_question,user_pw_answer) VALUE('{$user_id}','{$user_name}','{$user_email}','{$user_pw}','{$user_pw_question}','{$user_pw_answer}')";
	$ret = mysqli_query($mysqli,$sql);
	//True or False 반환
	if($ret){
	  echo "<script> alert('회원가입이 완료되었습니다.');</script>";
	  echo "<meta http-equiv='refresh'content=\"0;url='../home.php'\">";
	  exit(0);
	}else{
	  die('mysql query error :'.mysql_error());
	}

?>
