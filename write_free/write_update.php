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
//$_POST['bno']만 있을 때 bNo선언
if(isset($_POST['bno'])){
 $bno = $_POST['bno'];
}
//bno이 없다면(글 쓰기라면)변수 선언
if(empty($bno)){
$bID = $_SESSION['user_id'];
$date = date('Y-m-d H:i:s');
}
//항상 선언
$bTitle = $_POST['bTitle'];
$bContent = $_POST['bContent'];

//글 수정
if(isset($bno)){
 $sql='update board_free set b_title="'.$bTitle.'",b_content="'.$bContent.'"where b_no ='.$bno;
 $msgState = '수정';
} else{
	$sql = 'INSERT INTO board_free(b_no, b_title, b_content, b_date, b_hit, b_id) VALUE(null, "' . $bTitle . '", "' . $bContent . '", "' . $date . '", 0, "' . $bID . '")';
}

//메시지가 없다면(오류가 없다면)
if(empty($msg)){
	$result = mysqli_query($mysqli,$sql)or die(mysqli_error($mysqli));
	$msgState = '등록';

	if($result) { // query가 정상실행 되었다면,
		$msg = "글이 ".$msgState."되었습니다.";
		if(empty($bno)){
		$bno = $mysqli->insert_id;
		}
		$replaceURL = './view.php?bno=' . $bno;
	} else {
		$msg = "글을 등록하지 못했습니다.";
?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
exit;
	}
}

?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
