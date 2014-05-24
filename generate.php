<?php $title = "Làm đề"; include "head.html" ?>
		<style>
		#textEvaluation { width: 350px; }		
		#destlist { border-top: solid 2px #d7d7d7; margin-top: 4px; }		
		</style>
		<div><h1>TẠO ĐỀ KIỂM TRA <a href="#" id="buttonHelp">Hướng dẫn dùng</a></h1></div>
		<div id="guide" style="display: none; width: 400px; height: 250px;">
		<h2>Hướng dẫn<h2>
		<ul>
		<li>Vùng bên trái chứa các câu hỏi từ cơ sở dữ liệu. Vùng bên phải chứa các câu sẽ được đưa vào đề</li>
		<li>Đầu tiên bạn cần chọn ( chủ đề / lớp / loại ) rồi nhấn vào [ Lọc câu hỏi ] để thu hẹp các câu hỏi lựa chọn</li>
		<li>Trong vùng bên trái đưa vào đề, bấm đúp chuột vào câu hỏi đó</li>
		<li>Nhấn ngẫu nhiên để lấy 1 câu bất kỳ trong vùng bên trái sang vùng bên phải</li>
		<li>Trong vùng bên phải, dùng chuột bấm - kéo rê để sắp xếp lại thứ tự câu hỏi</li>
		<li>Trong vùng bên phải, bấm đúp chuột vào câu hỏi để xóa nó khỏi đề</li>
		<li>Ô nhập [ điểm ] ghi một loạt điểm các câu theo thứ tự phân cách nhau bằng 1 dấu trắng. VD giả sử Câu 1 (4 điểm), Câu 2 (5 điểm), Câu 3 (1 điểm), ta sẽ ghi vào ô là "4 5 1"</li>		
		</div>
		<div id="source">
		<form id="sourceForm">
			<div>
				Chủ đề:
				<select id="topic" name="topic">
				</select>
				Lớp: 
				<select id="grade" name="grade">
					<option selected>_</option>
					<option>10</option>
					<option>11</option>
					<option>12</option>
				</select>
				
				<input type="radio" checked name="type" value="0" />
				<span class="bar">Tự luận</span> &nbsp;
				<input type="radio" name="type" value="1" />
				<span class="bar">Trắc nghiệm</span>
				<br/>
				<input type="button" id="buttonFetch" value="Lọc quỹ câu hỏi" />
				<input type="button" id="buttonRandom" value="Chọn ngẫu nhiên" />
				<!-- Thời gian:
				<select id="time" name="time">
					<option selected>_</option>
					<option>15 phút</option>
					<option>45 phút</option>
					<option>90 phút</option>
					<option>120 phút</option>
					<option>180 phút</option>
				</select> -->
				<!-- <input type="button" id="buttonClear" value="Làm lại" />  -->					
			</div>
			<div id="srclist">
			</div>
		</form>
		</div>
		<div id="destination">			
			<div>
			Thang điểm <input type="textbox" name="evaluation" id="textEvaluation" />
			<a class="button" href="#" id="buttonExport">Chọn xong</a>
			</div>
			<strong>Các câu hỏi đã chọn:</strong> 
			<div id="destlist"></div>
		</div>
		<br/>		
		</div>
		
	</div>
	<script>
	var temp;
	$(document).ready(function() {
		$.get('/api.php?action=topic', function(data) { $('#topic').html(data); });
		$('#buttonFetch').click(function() {
			$.get('/api.php?action=question&' + $('#sourceForm').serialize(),
			function(data) { 
				$('#srclist').html(data); 
				$('.question').dblclick(function(obj) {
					// Đưa câu hỏi vào đề
					temp = obj;
					// Compatibility outerHTML
					var div = obj.target;
					if (obj.target.nodeName == 'IMG') {
						div = div.parentNode;
					} 
					var ref = div.getAttribute("ref");
					var html = "<div class='sel' ref='" + ref + "'>" + div.innerHTML + "</div>";
					$('#destlist').append(html); 
					$('.sel').dblclick(function(obj) {
						// Xóa câu hỏi khỏi đề
						temp = obj;
						// Compatibility outerHTML
						var div = obj.target;
						if (obj.target.nodeName == 'IMG') {
							div = div.parentNode;
						} 
						div.parentNode.removeChild(div);
					});
				});				
			});			
			$('#destlist').sortable();
			$('#srclist').disableSelection();
			$('#destlist').disableSelection();
		});
		$('#buttonHelp').click(function() {
			$('#guide').dialog({
				title: 'Hướng dẫn làm đề'
			});
			return false;
		});
		$('#buttonExport').click(function() {
			var selected = new Array();
			$('.sel').each(function(index, value) {
				selected[selected.length] = value.getAttribute("ref");
			});
			if (selected.length) {
				window.location.href = "/export.php?select=" + selected.toString() + "&evaluation=" + $('#textEvaluation').val();
			} else {
				alert("Chưa có câu hỏi nào được chọn");
			}
		});
		$('#buttonRandom').click(function() {
			var question = $('.question');
			var random = Math.round(Math.random() * question.length);			
			var div = question[random];
			if (div) {
				var ref = div.getAttribute("ref");
				var html = "<div class='sel' ref='" + ref + "'>" + div.innerHTML + "</div>";
				$('#destlist').append(html);
			}
		});
		$('#buttonClear').click(function() {
			$('#destlist').html('');
		});
	});
	</script>
</body>
</html>
		