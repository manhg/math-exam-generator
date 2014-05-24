<?php $title = "Nhập câu hỏi"; include "head.html" ?>
		<h1>NHẬP CÂU HỎI</h1>
		<div>		
		<form id="question_form" action="" method="POST">
			<div id="meta">
				<div>
					<span>Loại câu hỏi</span><br/>
					<input type="radio" checked name="type" value="0" />
					<span class="bar">Tự luận</span><br/>
					<input type="radio" name="type" value="1" />
					<span class="bar">Trắc nghiệm</span>
				</div>
				<div>
					<span>Lớp</span><br/>
					<select name="grade" size="3">
						<option selected>10</option>
						<option>11</option>
						<option>12</option>
					</select>				
				</div>
				<div>
					<span>Thời gian làm bài (phút)</span><br/>
					<!-- <input type="textbox" name="estimate" /> -->
					<select name="estimate" size="3">
						<option>5</option>
						<option selected>10</option>
						<option>15</option>
						<option>20</option>
						<option>30</option>
					</select>
				</div>
				<div>
					<span>Mức độ</span><br/>
					<select name="difficulty" size="3">
						<option value="1" selected>Trung bình</option>
						<option value="0">Dễ</option>
						<option value="2">Khó</option>
					</select>				
				</div>
			</div>
			<div>Nhóm <input type="textbox" name="category" id="textCategory" /></div>
			<div>
				Nội dung câu hỏi<br/>
				<textarea id="question_content" name="content" cols="70" rows="6"></textarea>
			</div>
			<div>
				Đáp án (nếu có)<br/>
				<textarea id="answer_content" name="answer" cols="70" rows="4"></textarea>
			</div>
			<input id="preview" type="button" value="Xem thử" />			
			<input id="submit" type="button" value="Lưu lại" />
			<div id="pad"></div>
			</div>
		</form>
		<div class="line"></div>
		<a href="/latex.pdf">Hướng dẫn viết nhập câu hỏi</a> |
		Số câu hỏi đã nhập vào quỹ: 
		<strong><?php
		include "config.php";
		$r = mysql_query("SELECT COUNT(*) AS stat FROM question");
		$row = (mysql_fetch_assoc($r)); 
		echo $row['stat'];
		?></strong>
		</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#preview').click(function() {
				var questionContent = $('#question_content').val() + "\n\n" + $('#answer_content').val();
				$.post('preview.php', { "text": questionContent }, function(data) {
					$('#pad').html(data);
				});
			});
			$('#submit').click(function() {
				 var data = $("#question_form").serialize();
				 jQuery.post('save.php', data, function(response) { 
					$("#pad").html("<span class='red'>ĐÃ LƯU</span>" + response); 
					$("#question_content").val("");
					$("#question_content").focus();
				}, 'html');
			});
		});
	</script>
</body>
</html>