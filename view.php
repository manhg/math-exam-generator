<?php $title = "Xem cơ sở dữ liệu"; include "head.html" ?>
		<h1>XEM CƠ SỞ DỮ LIỆU</h1>
		<style>#body { width: 700px; }</style>		
		<div>
		<?php		
		$__TYPE = array(0 => "Tự luận", 1 => "Trắc nghiệm");
		$__DIFFICULTY = array(0 => "Dễ", 1 => "Trung bình", 2 => "Khó");
		include 'config.php';
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$n = isset($_GET['n']) ? $_GET['n'] : 10;		
		$r = mysql_query("SELECT MAX(id) AS maxid FROM question");
		$row = mysql_fetch_assoc($r); 
		$maxid = $row['maxid'];		
		$next = ($id + $n) > $maxid ? "" : sprintf("<a class='button' href='view.php?n=%d&id=%d'>TIẾP</a>", $n, $id + $n);
		$back = ($id == 0 ? "" : sprintf("<a class='button' href='view.php?n=%d&id=%d'>TRƯỚC</a>", $n, $id - $n));
		echo "<div>$back $next</div>";
		$sql = sprintf("SELECT * FROM question WHERE id >= $id AND id < %d ORDER BY id ", $id + $n);
		$r = mysql_query($sql);
		while ($row = mysql_fetch_object($r)) {			
			?>
			<div class="q">
				<div class="meta"><div class="no"><?=$row->id?></div> <a href="edit.php?id=<?=$row->id?>">Thay đổi</a>
					<?=$__TYPE[$row->type]?> 
					- <?=$__DIFFICULTY[$row->difficulty]?> - <?=$row->estimate?> phút
					- Lớp <?=$row->grade?> - <?=$row->category?>
				</div>
				<div><?=nl2br($row->content)?></div>
			</div>
			<?php 
		}
		echo "<div>$back $next</div>";
		?>
		</div>
		</div>
	</div>
</body>
</html>