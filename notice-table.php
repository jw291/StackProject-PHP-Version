<?php
//세션사용을 하기 위한 필수메서드, 세션사용선언
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
/* 페이징 시작 */
	//페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	/* 검색 시작 */

	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}

	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}

	/* 검색 끝 */

	$sql = 'select count(*) as cnt from board_advertisement'. $searchSql;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$allPost = $row['cnt']; //전체 게시글의 수

	if(empty($allPost)) {
	$emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
	} else {
	$onePage = 10; // 한 페이지에 보여줄 게시글의 수.
	$allPage = ceil($allPost / $onePage); //전체 페이지의 수

	if($page < 1 && $page > $allPage) {
?>
		<script>
			alert("존재하지 않는 페이지입니다.");
			history.back();
		</script>
<?php
		exit;
	}

	$oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
	$currentSection = ceil($page / $oneSection); //현재 섹션
	$allSection = ceil($allPage / $oneSection); //전체 섹션의 수

	$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

	if($currentSection == $allSection) {
		$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
	} else {
		$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
	}

	$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
	$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

	$paging = '<ul>'; // 페이징을 저장할 변수

	//첫 페이지가 아니라면 처음 버튼을 생성
	if($page != 1) {
		$paging .= '<li class="page page_start"><a href="./home.php?page=1' . $subString . '">처음</a></li>';
	}
	//첫 섹션이 아니라면 이전 버튼을 생성
	if($currentSection != 1) {
		$paging .= '<li class="page page_prev"><a href="./home.php?page=' . $prevPage . $subString . '">이전</a></li>';
	}

	for($i = $firstPage; $i <= $lastPage; $i++) {
		if($i == $page) {
			$paging .= '<li class="page current">' . $i . '</li>';
		} else {
			$paging .= '<li class="page"><a href="./home.php?page=' . $i . $subString . '">' . $i . '</a></li>';
		}
	}

	//마지막 섹션이 아니라면 다음 버튼을 생성
	if($currentSection != $allSection) {
		$paging .= '<li class="page page_next"><a href="./home.php?page=' . $nextPage . $subString . '">다음</a></li>';
	}

	//마지막 페이지가 아니라면 끝 버튼을 생성
	if($page != $allPage) {
		$paging .= '<li class="page page_end"><a href="./home.php?page=' . $allPage . $subString . '">끝</a></li>';
	}
	$paging .= '</ul>';

	/* 페이징 끝 */


	$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

	$sql = 'select * from board_advertisement' . $searchSql . ' order by b_no desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	$result = $mysqli->query($sql)or die(mysqli_error($mysqli));
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
  <title>STACK</title>

  <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  <!--a태그 클릭시 색깔 바뀌게 하기-->
  <style type="text/css">
  a:link{text-decoration: none; color: #2E64FE;}
  a:visited{
  text-decoration: underline;
  font-style:italic;
  color: #682692;
  }
  </style>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="./css1/normalize.css" />
  <link rel="stylesheet" href="./css1/board.css" />
  <script src="./js1/jquery-2.1.3.min.js"></script>
  <title>????</title>
  <script language="javascript">


//== 로그인 안한상태에서 글쓰기 버튼 클릭시 alert띄우기==
	function writestatus(){
		alert("로그인 이후 글쓰기가 가능합니다");
	}
// === 쿠키값 가져오기 ===
    function getCookie(name) {
      var Found = false
      var start, end
      var i = 0

      while(i <= document.cookie.length) {
        start = i
        end = start + name.length

        if(document.cookie.substring(start, end) == name) {
          Found = true
          break
        }
        i++
      }

      if(Found == true) {
        start = end + 1
        end = document.cookie.indexOf(";", start)
          if(end < start)
            end = document.cookie.length
        return document.cookie.substring(start, end)
      }
      return ""
    }
//쿠키 삭제하기.
  function deleteCookie(cookieName){
	var expireDate = new Date();

	expireDate.setDate( expireDate.getDate() -1);
	document.cookie = cookieName + "=" + "; expires=" + expireDate.toGMTString() + "; path=/";
	alert("쿠키가 삭제되었습니다.");
  }

  function openPopup(){
        var noticeCookie=getCookie("popup");  // 쿠키변수 이름

        if (noticeCookie != "no"){
		window.open('08_2_popup.html','pop1', "width=470, height=450, left=100, top=50");
        }else{alert('쿠키가 걸려있음.')}
        // window.open('팝업창 웹페이지','윈도우명','width=350,height=400,top=50,left=150');
    }
  </script>



</head>

<!-- 삽입해야 할 소스 끝 -->
<body class="fixed-nav sticky-footer bg-dark" id="page-top">

  <!--navbar-dark: navbar에 있는 모든 글씨 색깔 -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"  id="mainNav">
    <a class="navbar-brand" href="home.php" onclick="home.php"><img src="logo.png"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">

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

		            <li>

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
		if(isset($_SESSION['is_login'])){//세션 값이 있을때 = "로그인 이후 상태"
		?>
		        <li class="nav-item">
		          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
		            <i class="fa fa-fw fa-sign-out"></i>로그아웃</a>
		        </li>
		<?php
		}else{
		?>
			<li class="nav-item">
		            <a class="nav-link" href="login.php">
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
          <a href="home.php" >STACK</a>
        </li>
        <li class="breadcrumb-item active">공지사항 게시판</li>
      </ol>

      <!--table-->
			<article class="boardArticle">
					<div class="card mb-3" style="width:1500px; margin-left:150px; ">
						<div class="card-header">
							<i class="fa fa-table"></i> 공지 게시판  </div>
					<div id="boardList">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered"  style="width:100%"cellspacing="0">
									<thead>
										<tr>
											<th style="text-align: center;">번호</th>
											<th style="text-align: center;">제목</th>
											<th style="text-align: center;">작성자</th>
											<th style="text-align: center;">작성 일자</th>
											<th style="text-align: center;">조회수</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th style="text-align: center;">번호</th>
											<th style="text-align: center;">제목</th>
											<th style="text-align: center;">작성자</th>
											<th style="text-align: center;">작성 일자</th>
											<th style="text-align: center;">조회수</th>
										</tr>
									</tfoot>
									<tbody>
<?php
							if(isset($emptyData)) {
							echo $emptyData;
							} else {
												while($row = mysqli_fetch_assoc($result))
										{
								$datetime = explode(' ',$row['b_date']);
								$date = $datetime[0];
								$time = $datetime[1];
								if($date == Date('Y-m-d'))
									$row['b_date']=$time;
								else
									$row['b_date']=$date;
								?>
							<?php
							//댓글 갯수 뽑아오기
							$cosql = 'select count(*) as cnt from comment_advertisement where b_no = '.$row['b_no'];
							$coresult = mysqli_query($mysqli,$cosql);
							$corow = mysqli_fetch_assoc($coresult);
							?>
													<tr>
														<td class="no"><?php echo $row['b_no']?></td>
							<!--write/view.php?bno에서 마지막 bno는 view.php에서 GET으로 받는다. 그 bno값은 row['b_no']이다.-->
														<td class="title">
								<a href="write/view.php?bno=<?php echo $row['b_no']?>"><?php echo $row['b_title']?><?php if($corow['cnt'] > 0){?><?php echo '('.$corow['cnt'].')' ?></a>
								<?php } ?>
							<?
							if($row['b_date'] == $time){
echo "<img src='./new_icon_origin.png' width='15' heigh='15'/>";
}
?>
								</a>
								    </td>
									    <td class="author"><?php echo $row['b_id']?></td>
									    <td class="date"><?php echo $row['b_date']?></td>
									    <td class="hit"><?php echo $row['b_hit']?></td>
								    </tr>
							<?php
								}
							}
							?>



									</tbody>
								</table>
							</div>
							<div class="btnSet">

<?php if(isset($_SESSION['is_login'])){//세션 값이 있을때 = "로그인 이후 상태"
?>
	<a class="btnWrite btn" href="write/write.php">글쓰기</a>

<?php
}else{
?>
	<a href="#" class="btnWrite btn" onclick="writestatus()">글쓰기</a>
<?php
}
?>
</div>
        </div>
	<div class="paging">
		<?php echo $paging ?>
	</div>
			<div class="searchBox">
				<form action="./notice-table.php" method="get">
					<select name="searchColumn">
						<option <?php echo $searchColumn=='b_title'?'selected="selected"':null?> value="b_title">제목</option>
						<option <?php echo $searchColumn=='b_content'?'selected="selected"':null?> value="b_content">내용</option>
						<option <?php echo $searchColumn=='b_id'?'selected="selected"':null?> value="b_id">작성자</option>
					</select>
					<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
					<button type="submit">검색</button>
				</form>
			</div>
          </div>
	       </div>
      </div>
    </div>
</article>
    <!-- /.container-fluid-->
    <!-- Scroll to Top Button-->
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
          <div class="modal-body">로그아웃 하시려면 버튼을 눌러주세요.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">취소</button>
            <a class="btn btn-primary" href="logout.php">로그아웃</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
