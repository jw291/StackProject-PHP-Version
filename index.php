<!DOCTYPE html>
<html>

<head>
<style type="text/css">
  a:link{text-decoration: none; color: #2E64FE;}
  a:visited{
  text-decoration: underline;
  font-style:italic;
  color: #682692;
  }
  </style>
<link rel="stylesheet" href="calendar/fullcalendar/fullcalendar.min.css" />

    <!--Font Awesome-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
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
  <link href="css/search.css" rel="stylesheet">
  <script src="./js1/jquery-2.1.3.min.js"></script>
  <script src="./calendar/fullcalendar/lib/jquery.min.js"></script>
  <script src="./calendar/fullcalendar/lib/moment.min.js"></script>
  <script src="./calendar/fullcalendar/fullcalendar.min.js"></script>
<script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "fetch-event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'add-event.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end,
                    type: "POST",
                    success: function (data) {
                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        
        editable: true,
        eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'edit-event.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "delete-event.php",
                    data: "&id=" + event.id,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }

    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<div class="content-wrapper">
    <div class="container-fluid">
      
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="home.php" >STACK</a>
        </li>
        <li class="breadcrumb-item active">참여 중인 게시판</li>
      </ol>

    
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i>
          선택한 스레드 프로필</div>
          <div class="card-body">
            <div style="width:200px; height:150px; border:1px; float:left; margin-right:10px;">
              <img src="images-4.png" alt="스레드 프로필사진" border="3px" width="150px" height="150px" align="left">
            </div>
            <div style="width:500px; height:150px; border:1px; float:left;">스레드 이름: <?php echo $threadname ?> </div>
              <br>
           
            </div>
          </div>
        </div>

      <!--calender-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i>
          해당 스레드의 달력 부분// 이미지만 넣은거임</div>
          <div class="card-body respoonse" id ="calendar">

          </div>
        </div>

      <!-- 스레드 게시판 table-->
			<article class="boardArticle">
					<div class="card mb-3" style="width:2100px; ">
						<div class="card-header">
							<i class="fa fa-table"></i> 스레드 커뮤니티 게시판 </div>
					<div id="boardList">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" style="width:1500px"cellspacing="0">
									<thead>
										<tr>
											<th style="text-align: center;">글 번호</th>
											<th style="text-align: center;">제목</th>
											<th style="text-align: center;">작성자</th>
											<th style="text-align: center;">작성일</th>
											<th style="text-align: center;">조회수</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th style="text-align: center;">글 번호</th>
											<th style="text-align: center;">제목</th>
											<th style="text-align: center;">작성자</th>
											<th style="text-align: center;">작성일</th>
											<th style="text-align: center;">조회수</th>
										</tr>
									</tfoot>
									<tbody>




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

					<?php
					}
					?>
					</div>
							</div>
					<div class="paging">
					<?php echo $paging ?>
					</div>
						<div class="searchBox">
							<form action="./mythread.php" method="get">
								<select name="searchColumn">
									<option <?php echo $searchColumn=='#'?'selected="selected"':null?> value="#">제목</option>
									<option <?php echo $searchColumn=='#'?'selected="selected"':null?> value="#">내용</option>
									<option <?php echo $searchColumn=='#'?'selected="selected"':null?> value="#">작성자</option>
								</select>
								<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
								<button type="submit">검색</button>
							</form>
						</div>
						</div>
					</div>
				</article>
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
</body>


</html>
