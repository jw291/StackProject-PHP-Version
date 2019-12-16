<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>스레드 개설</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <!-- 회원가입 중복체크 폼 js-->
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js" ></script>
<script type="text/javascript" src="../signupjs/registerchecker.js"></script>
<link rel="stylesheet" href="../css2/mySignupForm.css" />
</head>
<!---->
<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">스레드 개설하기</div>
      <div class="card-body">
        <form class="form-sign" action="thread_constructUpdate.php" method=POST onsubmit="return checkSubmit()">
          <div class="form-group">
              <label for="exampleInputName">스레드 이름</label>
              <input class="memberIntroduce form-control" name="thread_name" type="text" aria-describedby="titleHelp" placeholder="스레드의 이름을 정해주세요.">
          </div>

          <div class="form-group">
            <label for="exampleInputName">스레드 분류</label>
            <input class="memberMajor form-control" name="thread_category" type="text" aria-describedby="majorHelp" placeholder="분류를 입력하시오.">
          </div>

          <div class="form-group">
              <label for="exampleInputName">스레드 소개</label>
              <input class="memberMotive form-control" name="thread_description" type="text" aria-describedby="introHelp" placeholder="간단히 작성해주세요.">
          </div>
          
	        <div class="form-group">

          <button class="btn btn-lg btn-primary btn-block submit" type="submit">Submit</button>
        </form>

        <div class="text-center">
          <br>
	        <a class="d-block small" href="home.php">메인페이지로</a>
          <a class="d-block small" href="advertice-table.php">목록으로</a>
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
