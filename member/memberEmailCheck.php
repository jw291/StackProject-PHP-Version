<?
$host = 'localhost';
$user = 'root';
$pass = 'digh1221';

$mysqli = new mysqli($host,$user,$pass);
$ret = mysqli_select_db($mysqli,'stack');

$user_email = $_POST['memberEmailAddress'];

$sql = "SELECT * FROM user WHERE user_email ='{$user_email}'";
$res = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($res);

if($row >= 1){
        echo json_encode(array('res'=>'bad'));
    }else{
        echo json_encode(array('res'=>'good'));
    }

?>
