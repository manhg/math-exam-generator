<?php 
include "config.php";

if (!isset($_GET['id'])) die("MISSING ID");
$id = $_GET['id'];
$result = mysql_query("SELECT * FROM question WHERE id = $id");
$row = mysql_fetch_object($result); ?>
<?php $title = "Sửa câu hỏi"; include "head.html" ?>
		<h1>SỬA CÂU HỎI</h1>
		<style>
		#selectCategory { width: 600px; }
		</style>
		<div>
		<form id="question_form" action="" method="POST">
			<input type="hidden" name="id" value="<?=$id?>" />
			<div id="meta">
				<div>
					<span>Loại câu hỏi</span><br/>
					<input type="radio" <?=($row->type == 0) ? "checked" : "" ?> name="type" value="0" />
					<span class="bar">Tự luận</span><br/>
					<input type="radio" <?=($row->type == 1) ? "checked" : "" ?> name="type" value="1" />
					<span class="bar">Trắc nghiệm</span>
				</div>
				<div>
					<span>Lớp</span><br/>
					<select name="grade" size="3">
						<option <?=($row->grade == 10) ? "selected" : "" ?>>10</option>
						<option <?=($row->grade == 11) ? "selected" : "" ?>>11</option>
						<option <?=($row->grade == 12) ? "selected" : "" ?>>12</option>
					</select>				
				</div>
				<div>
					<span>Thời gian làm bài (phút)</span><br/>
					<!-- <input type="textbox" name="estimate" /> -->
					<select name="estimate" size="3">
						<option <?=($row->estimate == 5) ? "selected" : "" ?>>5</option>
						<option <?=($row->estimate == 10) ? "selected" : "" ?>>10</option>
						<option <?=($row->estimate == 15) ? "selected" : "" ?>>15</option>
						<option <?=($row->estimate == 20) ? "selected" : "" ?>>20</option>
						<option <?=($row->estimate == 30) ? "selected" : "" ?>>30</option>
					</select>
				</div>
				<div>
					<span>Mức độ</span><br/>
					<select name="difficulty" size="3">
						<option value="1"<?=($row->difficulty == 1) ? "selected" : "" ?>>Trung bình</option>
						<option value="0" <?=($row->difficulty == 0) ? "selected" : "" ?>>Dễ</option>
						<option value="2"<?=($row->difficulty == 2) ? "selected" : "" ?>>Khó</option>
					</select>				
				</div>
			</div>
			<div>
			<select name="category" id="selectCategory">
			<option selected><?=$row->category?></option>
			<?php
			$_REQUEST['action'] = 'topic';
			include 'api.php';
			?>
			</select>
			</div>
			<div>
				Nội dung câu hỏi<br/>
				<textarea id="question_content" name="content" cols="70" rows="6"><?=$row->content?></textarea>
			</div>
			<div>
				Đáp án (nếu có)<br/>
				<textarea id="answer_content" name="answer" cols="70" rows="4"><?=$row->answer?></textarea>
			</div>
			<input id="preview" type="button" value="Xem thử" />			
			<input id="submit" type="button" value="Lưu lại" />
			<div id="pad"></div>
			</div>
		</form>
		</div>
		<div class="line"></div>
		<a href="/latex.pdf">Hướng dẫn viết nhập câu hỏi</a> |
		<a href="/view.php">Xem cơ sở dữ liệu</a> |
		Số câu hỏi đã nhập vào quỹ: 
		<strong><?php
		$r = mysql_query("SELECT COUNT(*) AS stat FROM question");
		$row = (mysql_fetch_assoc($r));
		echo $row['stat'];
		?></strong>
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
				 jQuery.post('update.php', data, function(response) {
					$("#pad").html("<span class='red'>ĐÃ LƯU</span>" + response); 					
					window.location.href = "/view.php?id=<?=$id?>" ;
				}, 'html');
				
			});
		});
	</script>
</body>
</html>