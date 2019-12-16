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

//bno는 php의 echo로 보낸 값과 현재 동일함.
$bno = $_GET['bno'];
$btitle = $_GET[''];



if(!empty($bno) && empty($_COOKIE['board_advertisement_'.$bno])){
$sql = 'update board_advertisement set b_hit=b_hit +1 where b_no = '.$bno;
$result = mysqli_query($mysqli,$sql);
if(empty($result)){
?>
 <script>
	alert('오류가 발생했습니다.');
	history.back();
 </script>
	<?php
}else {
setcookie('board_advertisement_'.$bno,TRUE,time()+(60*60*40),'/');
 }
}
$sql = "select threadname, b_title, b_content, b_date, b_hit, b_id from board_advertisement where b_no= ".$bno;
$result = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>게시판 글쓰기</title>
  <!-- Bootstrap core CSS-->
  <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="./vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="./css1/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/normalize.css" />
  <link rel="stylesheet" href="./css/board.css" />
  <script src="./js/jquery-2.1.3.min.js"></script>
</head>
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="../home.php" onclick="home.php"><img src="logo.png"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
	<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          
<!-- 게시판 -->
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Board">
  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseboard" data-parent="#exampleAccordion">
    <i class="fa fa-fw fa-file"></i>
   <span class="nav-link-text">게시판</span>
 </a>
 <ul class="sidenav-second-level collapse" id="collapseboard">
  <li>
     <a href="advertice-table.php">홍보 게시판</a>
  </li>
  <li>
     <a href="notice-table.php">공지사항 게시판</a>
  </li>
</ul>
</li>

<!--스레드  -->
<?php
if(isset($_SESSION['is_login'])){//세션 값이 있을때 = "로그인 이후 상태"
?>
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
    <i class="fa fa-fw fa-file"></i>
      <span class="nav-link-text">마이페이지</span>
  </a>
  <ul class="sidenav-second-level collapse" id="collapseComponents">
    <li>
      <a href="thread-table.php">나의 스레드</a>
    </li>
    <li>
      <a href="#">스레드 개설하기</a>
    </li>
  </ul>
</li>

<?php
}else{
?>

<li class="nav-item">
<a class="nav-link" href="login.php">
  <i class="fa fa-fw fa-file"></i>
  <span>스레드 개설하기</span>
</a>
</li>

<?php
}
?>

<!--등록-->
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
        <i class="fa fa-fw fa-file"></i>
        <span class="nav-link-text">register</span>
      </a>
      <ul class="sidenav-second-level collapse" id="collapseMulti">

        <li>
              <a href="./member/register.php">회원가입</a>
            </li>
            <li>
              <a href="forgot-password.php">비밀번호 찾기</a>
            </li>

      </ul>
    </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">

<?php
if(isset($_SESSION['is_login'])){//세션 값이 없을때 = "로그인 전 상태"
?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>로그아웃</a>
        </li>
<?php
}else{
?>
	<li class="nav-item">
            <a class="nav-link" href="../login.php">
	     <i class="fa fa-fw fa-sign-in"></i>로그인</a>
        </li>
<?php
}
?>
      </ul>
    </div>
  </nav>
<!--nav end-->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="../home.php">STACK</a>
        </li>
        <li class="breadcrumb-item active">자유게시판</li>
      </ol>
    <article class="boardArticle">
	<div class="card mb-3">
       <div id="boardView">
	<div class="card-header">
	 <i class="text-muted smaller"></i><?php echo $row['b_title']?></div>
          <div class="media">
	   <div class="media-body">
	<strong>작성자: <?php echo $row['b_id']?></strong>
	<div class="text-muted bigger">모임이름: <?php echo $row['threadname']?></div>
	<div class="text-muted smaller">작성일: <?php echo $row['b_date']?></div>
	   </div>
	  </div>
	<hr style="color:#999999; border-style:dotted">
      <div id="boardContent"><?php echo $row['b_content']?></div>
<!--현재 로그인한 아이디 &_SESSION과 view의 아이디가 같으면 btnSet을 보여준다. (작성해야함)-->
<?php
if($row['b_id'] == $_SESSION['user_id']){
?>
	<div class="btnSet">
		<!--php echo $bno로 클릭한 게시물의 bno를 보내준다. 다른 곳에서 GET으로 받는다.-->
		<a style ="border-right-width: 0.15em; border-right-style: solid; border-right-color:#cdcdcd" href="./write.php?bno=<?php echo $bno?>">수정 </a>
		<a style ="border-right-width: 0.15em; border-right-style: solid; border-right-color:#cdcdcd" href="./delete.php?bno=<?php echo $bno?>">삭제 </a>
		<a style ="border-right-width: 0.15em; border-right-style: solid; border-right-color:#cdcdcd" href="../threadRegisterForm.php?bno=<?php echo $bno?>">가입신청</a>
		<a href="../home.php">목록</a>
	<!--목록 href는 자유게시판에서는 자유게시판, rpg는 rpg로 나중에 변경해주자.-->
	</div>
<?php
}else{
?>
	<div class="btnSet">
		<a href="../home.php">목록</a>
		<a href="../threadRegisterForm.php?bno=<?php echo $bno?>">가입신청</a>
	</div>
<?php
}
?>
<hr style="color:#999999; border-style:dotted">

	<!--댓글 php를 include시켜준다.-->
	<div id="boardComment">
		<?php require_once('./comment.php')?>
	</div>
     </div>
   </article>
</div>
</div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">로그아웃 하시겠습니까?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">취소 버튼을 누르면 로그아웃이 취소됩니다.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">취소</button>
            <a class="btn btn-primary" href="../logout.php">로그아웃</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="./vendor/chart.js/Chart.min.js"></script>
    <script src="./vendor/datatables/jquery.dataTables.js"></script>
    <script src="./vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="./js1/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="./js1/sb-admin-datatables.min.js"></script>
    <script src="./js1/sb-admin-charts.min.js"></script>
  </div>
  </body>
</html>
