<?php
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
//세션 사용 선언
session_start();

//login.php의 로그인폼에서 보내온 정보를 변수에 저장한다.
$id = $_POST['user_id'];
$pw = $_POST['user_pw'];

//user테이블에서 입력받은 아이디와 비밀번호가 일치하는 데이터 검색
$sql = "SELECT * FROM user WHERE user_id='{$id}' and user_pw='{$pw}'";
$resource = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
$num = mysqli_num_rows($resource);

$row=mysqli_fetch_assoc($resource);
//->$asoc:array=([no]->사용자 식별번호,[user_id]->아이디,[user_pw]->비밀번호,[user_name]->이메일)
if($num >0){//아이디와 패스워드가 일치하는 데이터가 검색된 경우.
	//session테이블에서 입력받는 아이디와 일치한 데이터가 있는지 검색한다.
	//session테이블 = 접속해있는 계정을 저장하는 테이블
$sql="SELECT * FROM session WHERE user_id='{$id}'";
$resource=mysqli_query($mysqli,$sql);
$num=mysqli_num_rows($resource);
	if($num>0){
		echo"<script> alert('이미 로그인한 아이디 입니다.');</script>";
	}else{
	 $sess_id = session_id();
	 //session_id(); 세션번호 반환
	 //value안의 변수를 인식을 못하는 문제 발생.
	 $sql="INSERT INTO session(no, user_id, user_name,session_id,jointhreadname) VALUE($row[no],'$id','$row[user_name]','$sess_id','$row[jointhreadname]')";
	 //사용자 식별번호, 아이디, 세션아이디 값을 세션테이블에 저장시킨다.
	 //다음 로그인 시 해당 테이블에 데이터 존재유무를 통해 로그인인지 아닌지 판단한다.
	 $ret = mysqli_query($mysqli,$sql);

	 //#세션변수에 데이터 추가
	 $_SESSION['user_id']=$id;
	 $_SESSION['user_name'] = $row['user_name'];
	 $_SESSION['is_login']=1;
	 $_SESSION['jointhreadname'] = $row['jointhreadname'];
	 //#로그인 환영 메세지 출력
	 echo"<script>alert('로그인 되었습니다.');</script>";
	 echo "<meta http-equiv='refresh'content=\"0;url='./home.php'\">";
	 exit(0);
	}
}else{//user테이블에 입력받은 아이디와 패스워드가 일치하는 데이터가 없다.
	 echo"<script>alert('아이디 또는 패스워드가 올바르지 않습니다.');</script>";
	 echo "<script>window.history.back();</script>";
	 exit(0);
}

?>
<meta http-equiv='refresh'content="0;url='./login.php">
