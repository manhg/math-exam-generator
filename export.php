<html>
<head> 
	<title>Xuất đề thi</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link type="text/css" href="/style.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header"> 
		2011 &copy; Qũy đề thi 
		| <a href="/new.php">Nhập câu hỏi</a>
		| <a href="/view.php">Xem và sửa</a>
		| <a href="/generate.php">Xuất đề thi</a>
		</div>
		<div id="body">		
			<h1>XUẤT ĐỀ THI</h1>			
			<div>			
				<!-- <a class="button" id="selectToCopy" href="#">CHỌN VÀ SAO CHÉP</a> -->
			</div>
			<div>Điền tiêu đề và chân trang vào các ô dưới đâu nếu cần</div>		
			<style>
			#body { width: 900px; }
			#exported div, #exported div p, strong, textarea { font: 13pt "Times New Roman"; }
			strong { font-weight: bold; }
			textarea { border: solid 1px #e7e7e7; width: 900px; }
			#exported { border-left: solid 1px #e7e7e7; border-right: solid 1px #e7e7e7; padding: 5px; }
			.line { height: 20px; padding: 3px; border-bottom: solid 2px #aaa; margin: 4px; }
			</style>			
			<div class="line">ĐỀ BÀI</div>
			<form action="pdf.php" method="POST">
				<p><input type="checkbox" name="print" />In trực tiếp bằng HTML (độ phân giải cao)</p>
				<input type="submit" value="Xuất ra .HTML" />
				<input type="hidden" name="select" value="<?=$_REQUEST['select']?>" />
				<input type="hidden" name="evaluation" value="<?=$_REQUEST['evaluation']?>" />
				<textarea id="page_header" name="header" cols="120" rows="5">Trường THPT Ba Vì
				
				ĐỀ KIỂM TRA 
				MÔN TOÁN
				Thời gian:
				</textarea>
				<div id="exported">
				<?php
				include "config.php";
				include "latex.php";
				$result = mysql_query(sprintf("SELECT * FROM question WHERE id IN (%s)", $_REQUEST['select']));
				$order = 0;
				$solution = "";
				$evaluation = explode(' ', $_REQUEST['evaluation']);
				if (count($evaluation) == mysql_num_rows($result) || empty($_REQUEST['evaluation'])) {
					while ($row = mysql_fetch_object($result)) {
						$order++;
						?>
						<div>
						<?php if (!empty($_REQUEST['evaluation'])) { ?>
							<strong>Câu <?=$order?> (<?=$evaluation[$order-1]?> điểm): </strong>
						<?php } else { ?>
							<strong>Câu <?=$order?>: </strong>
						<?php } ?>
						<?=latex($row->content)?>
						</div>
						<?php
						$solution .= "<div>Câu $order: ". latex($row->answer) ."</div>";
					}
				} else {
					echo "Lỗi: Thang điểm ghi chưa chính xác";
				}
				?>				
				</div>
				<textarea id="page_footer" name="footer" cols="120" rows="2"></textarea>
			</form>
			<div class="line">ĐÁP ÁN</div>
			<div id="solution">
				<?= $solution ?>
			</div>
			<script>
			$(document).ready(function() {
				
			});
			</script>	
		</div>
	</div>
</body>
</html>