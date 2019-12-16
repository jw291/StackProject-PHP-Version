<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>회원가입</title>
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
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form class="form-sign" action="registercheck.php" method=POST onsubmit="return(checkSubmit());">
          <div class="form-group">       
                <label for="exampleInputId">아이디 입력</label>
		<a href="#" style="margin-left: 220px;" class="memberIdCheck">중복 확인</a>
                <input class="memberId form-control" name="user_id" type="text" aria-describedby="nameHelp" placeholder="Enter ID"required autofocus>
		
                <div class="memberIdComment comment"></div>	          
          </div>

        <div class="form-group">	
            <label for="exampleInputName">이름 입력</label>
            <input class="memberName form-control" name="user_name" type="test" aria-describedby="nameHelp" placeholder="Enter Nickname">  
	</div>

	<div class="form-group">    
            <label for="exampleInputName">이메일 입력</label>
		<a href="#" style="margin-left: 176px;" class="memberEmailCheck">Email 중복 확인</a>
                <input class="memberEmailAddress form-control" name="user_email" type="test" aria-describedby="emailHelp" placeholder="Enter email">
                    <div class="memberEmailAddressComment comment"></div>
                
            </div>

        <div class="form-group">     
                <label for="exampleInputPassword1">비밀번호</label>
                <input class="memberPw form-control" name="user_pw" type="password" placeholder="Enter Password">
        </div>

	<div class="form-group"> 
                <label for="exampleInputPassword1">비밀번호 확인</label>
                <input class="memberPw2 form-control" name="user_pw2" type="password" placeholder="Enter RePassword">
		<div class="memberPw2Comment comment"></div>
        </div>

	<div class="form-group"> 
                <label for="exampleInputQnA">비밀번호 문답</label>
	<select name="find_account_question" style="width:290px">
		<option value="나의 보물 1호는?">나의 보물 1호는?</option>
		<option value="나의 출신 초등학교는?">나의 출신 초등학교는?</option>
		<option value="나의 출신 고향은?">나의 출신 고향은?</option>
		<option value="나의 이상형은?">나의 이상형은?</option>
		<option value="어머니 성함은?">어머니 성함은?</option>
		<option value="아버지 성함은?">아버지 성함은?</option>
		<option value="가장 좋아하는 색깔은?">가장 좋아하는 색깔은?</option>
	</select>
        <br>
	<input class="form-control" type="text" name="find_account_answer" placeholder="답변">
	 
          <button class="btn btn-lg btn-primary btn-block submit" type="submit">register</button>
        </form>

	<div class="formCheck">
            <input type="hidden" name="idCheck" id="idCheck" class="idCheck" />
            <input type="hidden" name="pwCheck2" id="pwCheck2" class="pwCheck2" />
            <input type="hidden" name="eMailCheck" id="eMailCheck" class="eMailCheck" />
	    <input type="hidden" name="emailOverlapCheck" id="emailOverlapCheck" class="emailOverlapCheck"/>
        </div>

        <div class="text-center">
          <a class="d-block small mt-3" href="../login.php">Login Page</a>
          <a class="d-block small" href="../forgot-password.php">Forgot Password?</a>
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


