<?php
include_once('./mailer.lib.php');
$host ="localhost";
$user ="root";
$pass ="digh1221";
//mysql 연동
$mysqli = new mysqli($host,$user,$pass);
if(!$mysqli){
	die('MySQL connect ERROR:'.mysql_error());
}
//데이터 베이스 진입
$ret = mysqli_select_db($mysqli,'stack');
if(!$ret){
	die('db connect error:'.mysql_error());
}
//입력한 아이디의 질문과 답변을 찾아낼 row
$user_id = $_POST['user_id'];
$sql = "select * from user where user_id='$user_id'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);

//그 질문,답변과 비밀번호 찾기화면에서 선택한 질문답변이 일치하는지
$find_question = $_POST['find_question'];
$find_answer= $_POST['find_answer'];
//메일에 도착하는 비밀번호 뒤에 3자리는 별로 표시.
$pw = mb_substr($row['user_pw'],'0',-3)."***";

$cosql = "select count(*) as cnt from user where user_id='$user_id'";
$coresult = mysqli_query($mysqli,$cosql);
$corow = mysqli_fetch_assoc($coresult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>비밀번호 찾기</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">비밀번호 찾기</div>
      <div class="card-body">
        <div class="text-center mt-4 mb-5">


<?php
if($corow['cnt'] > 0 && $user_id != null && $row['user_pw_question'] == $find_question && $row['user_pw_answer'] == $find_answer){

	mailer("Stack","ggwebsite@naver.com",$row['user_email'],"비밀번호 정보입니다. ","회원님의 비밀번호는 [$pw] 입니다.","1");
?>	<h4>메일을 확인해주세요.</h4>
<?php
}else if($corow['cnt'] == 0 && $user_id != null){
?>	<h4>Forgot your password?</h4>
	  <p>아이디가 존재하지 않습니다.</p>
<?php
}else if($user_id == null){
?>	<h4>비밀번호를 잊으셨습니까?</h4>
	<p>아이디와 비밀번호를 입력하세요</p>
<?php
}else if($row['user_pw_question'] != $find_question || $row['user_pw_answer'] != $find_answer){
 echo "<script> alert('비밀번호 문답을 다시 확인하세요.');</script>";
?>
<?php
}
?>
        </div>
        <form  class="form-signin" method=POST action="forgot-password.php">
	  <div class="form-group">
		  <label for="exampleInputQnA">비밀번호 문답</label>
	    <select name="find_question" style="width:290px">
		<option value="나의 보물 1호는?">나의 보물 1호는?</option>
		<option value="나의 출신 초등학교는?">나의 출신 초등학교는?</option>
		<option value="나의 출신 고향은?">나의 출신 고향은?</option>
		<option value="나의 이상형은?">나의 이상형은?</option>
		<option value="어머니 성함은?">어머니 성함은?</option>
		<option value="아버지 성함은?">아버지 성함은?</option>
		<option value="가장 좋아하는 색깔은?">가장 좋아하는 색깔은?</option>
	    </select>
	    <input class="form-control" type="text" name="find_answer" placeholder="답변">
	  </div>

          <div class="form-group">
		  <label for="enterId">아이디 입력</label>
            <input class="form-control" name="user_id" type="text" placeholder="Enter id">
          </div>
          <button class="btn btn-primary btn-block" type="submit">비밀번호 찾기</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="./member/register.php">Register an Account</a>
          <a class="d-block small" href="login.php">Login Page</a>
	  <a class="d-block small" href="../home.php">home</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
