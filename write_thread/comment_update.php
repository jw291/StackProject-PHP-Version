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
	$w = '';
	$coNo = 'null';

	if(isset($_POST['jointhreadname'])) {
		$jointhreadname = $_POST['jointhreadname'];
	}
	//2Depth & 수정 & 삭제
	if(isset($_POST['w'])) {
		$w = $_POST['w'];
		$coNo = $_POST['co_no'];
	}

	$bno = $_POST['bno'];

	if($w !== 'd') {//$w 변수가 d일 경우 $coContent와 $coId가 필요 없음.
		$coContent = $_POST['coContent'];
		if($w !== 'u') {//$w 변수가 u일 경우 $coId가 필요 없음.
			$coId = $_SESSION['user_id'];
		}
	}


	if(empty($w) || $w === 'w') { //$w 변수가 비어있거나 w인 경우
		$msg = '작성';
		$sql = "insert into comment_thread values(null, $bno ,'$_SESSION[jointhreadname]',$coNo, '{$coContent}','{$coId}')";
		
		if(empty($w)) { //$w 변수가 비어있다면,
			$result = $mysqli->query($sql);

			$coNo = $mysqli->insert_id;
			$sql = "update comment_thread set co_order = co_no where threadname = '$_SESSION[jointhreadname]' and co_no = " . $coNo;
		}

	} else if($w === 'u') { //작성
		$msg = '수정';

		$sql = "select count(*) as cnt from comment_thread where threadname = '$_SESSION[jointhreadname]' and co_no = " . $coNo;
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();

		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
?>
			<script>
				alert('없는 게시글');
				history.back();
			</script>
<?php
			exit;
		}

		$sql = "update comment_thread set co_content = '$coContent' where threadname = '$_SESSION[jointhreadname]' and co_no = " . $coNo;

	} else if($w === 'd') { //삭제
		$msg = '삭제';
		$sql = "select count(*) as cnt from comment_thread where threadname = '$_SESSION[jointhreadname]' and co_no = " . $coNo;

		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();

		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
?>
			<script>
				alert('없는 게시글');
				history.back();
			</script>
<?php
			exit;
		}
		$sql = "delete from comment_thread where threadname = '$_SESSION[jointhreadname]' and co_no = " . $coNo;

	} else {
?>
		<script>
			alert('정상적인 경로를 이용해주세요.');
			history.back();
		</script>
<?php
		exit;
	}

	$result = $mysqli->query($sql);
	if($result) {
?>
		<script>
			alert('댓글이 정상적으로 <?php echo $msg?>되었습니다.');
			location.replace("./view.php?bno=<?php echo $bno?>");
		</script>
<?php
	} else {
?>
		<script>
			alert('댓글 <?php echo $msg?>에 실패했습니다.');
			history.back();
		</script>
<?php
		exit;
	}
?>
