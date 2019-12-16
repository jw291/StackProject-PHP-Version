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

$sql = 'select * from comment_free where co_no=co_order and b_no=' . $bno;
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_assoc($result)) {
?>
<div id="commentView">
<form action="comment_update.php" method="post" >
	
		<input type="hidden" name="bno" value="<?php echo $bno?>">
	
	<ul class="oneDepth">
		<li>		
	<!--commentSet은 css와 자바스크립트에서 이용하기 위해서 지-->
		<div id="co_<?php echo $row['co_no']?>" class="commentSet">
	<!--commentinfo는 css에서 float속성을 overflow;hidden;으로 막기 위해서 각 div를 감싼다.-->
		<div class="commentInfo" id="commentInfo">
	<!--commentid는 댓글의 아이디가 출력되는 부분. span태그에서는 자바스크립트에서 순수 아이디 값만 얻어내기 위해 감쌈.-->
		<div class="commentId">작성자: <span class="coId"><?php echo $row['co_id']?></span></div>
		<div class="commentBtn">
		<a href="#" class="comt write">댓글</a>

<?php
if($row['co_id'] == $_SESSION['user_id']){
?>
	
		<a href="#" class="comt modify">수정</a>
	</form>

	<form id="deleteform" name="deleteform" action="comment_update.php" method="post"  style="width:버튼크기;float:right;margin-left: 5px;">
	
	<!--commentinfo는 css에서 float속성을 overflow;hidden;으로 막기 위해서 각 div를 감싼다.-->
	<!--commentid는 댓글의 아이디가 출력되는 부분. span태그에서는 자바스크립트에서 순수 아이디 값만 얻어내기 위해 감쌈.-->
		
	<input type="hidden" id="bno" name="bno" value="<?php echo $bno?>">
	<input type="hidden" name="w" value="d">
	<input type="hidden" name="co_no" value= <?php echo $row['co_no']?>>
	<a href="#" class="button comt delete" onclick="formSubmit(); return false;">삭제</a>

	
	</form>
 </div>

<!--삭제방식을 스크립트에서 html으로 바꿔서 form을 나눠주었다. form안에 form은 불가능하기 때문이다.-->
<!--그리고 form에 confirm을 return해서 확인을 눌러야 post가 전달된다.-->
<!---->



<?php
}
?>		
<form action="comment_update.php" method="post">
</div>

	<div class="commentContent"><?php echo $row['co_content']?></div>
		</div>
			<?php
				$sql2 = 'select * from comment_free where co_no!=co_order and co_order=' . $row['co_no'];
				$result2 = mysqli_query($mysqli,$sql2);
			
				while($row2 = mysqli_fetch_assoc($result2)) {
			?>
	<ul class="twoDepth">
		<li>
			<div id="co_<?php echo $row2['co_no']?>" class="commentSet">
			<div class="commentInfo">
		<div class="commentId">작성자:  <span class="coId"><?php echo $row2['co_id']?></span></div>
<?php
//co_id는 대댓이 아닌 댓글이라서 다른사람 댓글의 대댓글을 달면 수정 삭제가 안뜨는 오류
if($row['co_id'] == $_SESSION['user_id']){
?>
		<div class="commentBtn">
		<a href="#" class="comt modify">수정</a>
		<a href="#" class="comt delete">삭제</a>
		</div>
<?php
}
?>
		</div>
		<div class="commentContent"><?php echo $row2['co_content'] ?></div>
	</div>
</li>
</ul>
			<?php
				}
			?>
		</li>
	</ul>
</form>	

<?php } ?>

</div>
<br>
<form action="comment_update.php" method="post">
	<input type="hidden" name="bno" value="<?php echo $bno?>">
	<table>
		<tbody>
			<tr>
				<th scope="row"><label for="coContent">내용</label></th>
				<td><textarea cols="65"name="coContent" id="coContent"></textarea></td>
			</tr>
		</tbody>
	</table>
	<div class="btnSet">
		<input type="submit" value="댓글 등록">
	</div>
</form>
<script>
$(document).ready(function () {		
		$('#commentView').delegate('.comt', 'click', function () {
		if($(this).hasClass('delete')) {
		var thisParent = $(this).parents('.commentSet');
			//현재 작성 내용을 변수에 넣고, active 클래스 추가.
			var commentSet = thisParent.html();
			thisParent.addClass('active');
		
			//취소 버튼
			var commentBtn = '<a href="#" class="addComt cancel">취소</a>';
				
		
	
			//commentInfo의 ID를 가져온다.
			var co_no = thisParent.attr('id');
			
			//전체 길이에서 3("co_")를 뺀 나머지가 co_no
			co_no = co_no.substr(3, co_no.length);
		

			var con_check = confirm("삭제하시겠습니까?");
			if(con_check == true){
				$('input[name="co_no"]').val(co_no);
				document.getElementById("deleteform").submit();
			}else if(con_check ==false){
				showbtn();
			}
		
		}
	});

});

</script>
<script>
function showbtn(){
 $('.comt').show();
}
</script>
<!--자바 스크립트 시작-->
<script>
//jqery의 문법
//$대신 jQery로 대체 가능 document는 css의 document클래스에 있는 element를 찾음.
//document클래스의 ready메서드 이
	$(document).ready(function () {
		var action = '';
		
		$('#commentView').delegate('.comt', 'click', function () {
			
			//현재 위치에서 가장 가까운 commentSet 클래스를 변수에 넣는다.
			var thisParent = $(this).parents('.commentSet');
			//현재 작성 내용을 변수에 넣고, active 클래스 추가.
			var commentSet = thisParent.html();
			thisParent.addClass('active');
			//취소 버튼
			var commentBtn = '<a href="#" class="addComt cancel">취소</a>';
				
		
			
			
			
			//commentInfo의 ID를 가져온다.
			var co_no = thisParent.attr('id');
			
			//전체 길이에서 3("co_")를 뺀 나머지가 co_no
			co_no = co_no.substr(3, co_no.length);
			//변수 초기화

			var comment = ''; //뒤에서 내용을 더 추가하기 위해
			var coId = '';//write와 modify에서 다른 값을 추가 하기 위해
			var coContent = '';//수정할때 값을 추가 다른부분은 공백
			//$(this)는 .comt(댓글,수정,삭제)버튼
			//hasclass로 버튼들을 나눠주고 있음.
			if($(this).hasClass('write')) {
				//댓글 쓰기
				//버튼 삭제 & 추가
			$('.comt').hide();
				action = 'w';
				//ID 영역 출력
				coId = '<input type="text" name="coId" id="coId">';
			
			} else if($(this).hasClass('modify')) {
				//버튼 삭제 & 추가
			$('.comt').hide();
				//댓글 수정
				action = 'u';				
				//1depth댓글의 작성자명을 가져옴.
				coId = thisParent.find('.coId').text();
				//1depth컨텐츠를 가져옴.
				var coContent = thisParent.find('.commentContent').text();
				
			}
			//삭제는 스크립트에서 다루지 않음.
			 else if($(this).hasClass('delete')) {
				//댓글 삭제	
				action = 'd';
				
			
			}
			//input값이 post로 전송됨.
//action변수가 d==삭제일때는 아이디,내용부분이 필요 없으므로 d가 아닐경우에만 comment작성
							
				if(action !== 'd') {
				$(this).parents('.commentBtn').append(commentBtn);
					comment += '<div class="writeComment">';
					comment += '	<input type="hidden" name="w" value="' + action + '">';
					comment += '	<input type="hidden" name="co_no" value="' + co_no + '">';
					comment += '	<table>';
					comment += '		<tbody>';			
					comment += '			<tr>';
					comment += '				<th scope="row"><label for="coContent">내용</label></th>';
					comment += '				<td><textarea name="coContent" id="coContent">' + coContent + '</textarea></td>';
					comment += '			</tr>';
				comment += '		</tbody>';
				comment += '	</table>';
				comment += '	<div class="btnSet">';
				comment += '		<input type="submit" value="확인" >';
				comment += '	</div>';
				comment += '</div>';
				}

				
					
				//만든 comment변수 출
				thisParent.after(comment);
			return false;
		});
		
		$('#commentView').delegate(".cancel", "click", function () {
				$('.writeComment').remove();
				$('.commentSet.active').removeClass('active');
				$('.addComt').remove();
				$('.comt').show();
			return false;
		});
	});
</script>
