<?php
$host ="localhost";
$user ="root";
$pass ="digh1221";
	//연동 확인
	$mysqli = new mysqli($host,$user,$pass)or die(mysqli_error($mysqli));
	if(!$mysqli){
		die('MySQL connect ERROR:'.mysql_error());
	}
	//데이터 베이스 진입
	$ret = mysqli_select_db($mysqli,'stack');
	if(!$ret){
		die('db connect error:'.mysql_error());
	}
	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bno = $_POST['bno'];
	}
//글 삭제
if(isset($bno)) {
	//삭제 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
	$sql = 'select count(b_no) as cnt from board_free where b_no = ' . $bno;
	$result = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
	$row = mysqli_fetch_assoc($result);
	
	//비밀번호가 맞다면 삭제 쿼리 작성
	if($row['cnt']) {
		$sql = 'delete from board_free where b_no = ' . $bno;
	//틀리다면 메시지 출력 후 이전화면으로
	} else {
	echo $bno;
		$msg = '게시글이 존재하지 않습니다.';    
	?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
	<?php
		exit;
	}
}

	$result = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
	
//쿼리가 정상 실행 됐다면,
if($result) {
	$msg = '글이 삭제되었습니다.';
	$replaceURL = "../home.php";
} else {
	$msg = '글을 삭제하지 못했습니다.';
?>
	<script>
		alert("<?php echo $msg?>");
		history.back();
	</script>
<?php
	exit;
}


?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
