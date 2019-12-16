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

//수정 기능
//$_GET['bno']가 있을 때만 $bno를 선언한다.
if(isset($_GET['bno'])){
	$bno = $_GET['bno'];
}
if(isset($bno)){
	$sql='select threadname, b_title, b_content, b_id from board_thread where b_no='.$bno;
	$result = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
	$row = mysqli_fetch_assoc($result);
}

$threadname = $_GET['threadname'];
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
  <!--네이버 스마트 에디-->
  <script type="text/javascript" src="./nse_files/js/HuskyEZCreator.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
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
<!-- nav end-->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">STACK</a>
        </li>
        <li class="breadcrumb-item active">게시판 글쓰기</li>
      </ol>
	<!-- free board-->
	<article class="boardArticle">
		<h3>게시판 글쓰기</h3>
		<div id="boardWrite">
			<form action=./write_update.php method=POST>
			<!--form을 submit할때 bno값도 같이 전달돼야 하기 때문에 해놓음.-->
				<?php
				if(isset($bno)){
					echo '<input type="hidden" name="bno" value="'.$bno.'">';
				}
				?>
				<input type="hidden" name="threadname" value=<?php echo $_SESSION['jointhreadname']?>>
			<!--&bno가 존재한다면 b_id를 뽑아온다. 존재하지 않으면 인풋으로 입력할 수 있게 한다 하지만 수정할때 아이디를 바꿀 필요는 없으니 사실상 무쓸모-->
				<table id="boardWrite">
					<tbody>
						<tr>
							<th scope="row"><label for="bID">아이디</label></th>
							<td class="id">
								<?php
								if(isset($bno)) {
									echo $row['b_id'];
								} else { ?>

								<?php echo $_SESSION['user_id'];} ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title"><input type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content"><textarea name="bContent" id="bContent" style="width:605px; height:412px;"><?php echo isset($row['b_content'])?$row['b_content']:null?></textarea>
<script type="text/javascript">
var oEditors = []; $(
function(){ nhn.husky.EZCreator.createInIFrame({
oAppRef: oEditors, elPlaceHolder: "bContent",
//SmartEditor2Skin.html 파일이 존재하는 경로
sSkinURI: "./nse_files/SmartEditor2Skin.html",
htParams : { // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
bUseToolbar : true,
// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
bUseVerticalResizer : true,
// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
bUseModeChanger : true,
fOnBeforeUnload : function(){
 }
},
fOnAppLoad : function(){
//기존 저장된 내용의 text 내용을 에디터상에 뿌려주고자 할때 사용
oEditors.getById["ir1"].exec("PASTE_HTML", [""]);
},
fCreator: "createSEditor2" });
});
function submitContents(elClickedObj) {
  // 에디터의 내용이 textarea에 적용됩니다.
  oEditors.getById["bContent"].exec("UPDATE_CONTENTS_FIELD", []);
  // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

  try {
  elClickedObj.form.submit();
  } catch(e) {}
  }
</script>
</td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn" onclick="submitContents(this)">
						<?php echo isset($bno)?'수정':'작성'?>
					</button>
					<a href="../home.php" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
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
          <div class="modal-body">로그아웃 버튼을 누르면 로그인 세션 파괴</div>
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
