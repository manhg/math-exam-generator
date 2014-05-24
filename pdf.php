<?php
include "config.php";
include "latex.php";
?><html>
<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /></head>
<style media="print">
div { line-height: 13pt; } img { vertical-align: middle; width: auto; } 
.page {
  page-break-before: always;
}
@page { size: A4; margin: 2cm;  }
@page :left {
  @top-left {
    content: "";
  }
  @bottom-left {
    content: "";
  }
}
@page :right {
  @top-right {
    content: "";
  }
}
</style>
<?= nl2br($_REQUEST['header']) ?>
</textarea>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<?php 
$print = isset($_REQUEST['print']);
if ($print) {
 ?>
<script>
var temp = new Array();
var x = new Array();
$(document).ready(function() {
	$('.latex').load(function() {
		temp[temp.length] = $(this);
		x[temp.length] = Math.ceil($(this).height()/3) + " " + Math.ceil($(this).width()/3);
		$(this).css('height', Math.ceil($(this).height() / 3) + 'px');
		// $(this).css('width', Math.ceil($(this).width() / 3) + 'px'); 
	});
});
</script>
<?php } ?>
<div id="exported">
	<div id="problem">
	<?php
	$result = mysql_query(sprintf("SELECT * FROM question WHERE id IN (%s)", $_REQUEST['select']));
	$order = 0;
	$solution = "";
	$evaluation = explode(' ', $_REQUEST['evaluation']);
	if (count($evaluation) == mysql_num_rows($result) || empty($_REQUEST['evaluation'])) {
		while ($row = mysql_fetch_object($result)) {
			?>
			<div>
			<?php if (!empty($_REQUEST['evaluation'])) { ?>
				<strong>Câu <?=++$order ?> (<?=$evaluation[$order-1]?> điểm): </strong>
			<?php } else { ?>
				<strong>Câu <?=++$order?>: </strong>
			<?php } ?>
			<?=latex($row->content, $print ? '\dpi{360}' : '')?>
			</div>
			<?php
			$solution .= "<div>Câu $order: ". latex($row->answer, $print ? '\dpi{360}' : '') ."</div>";
		}
	} else {
		echo "Lỗi: Thang điểm ghi chưa chính xác.";
	}
	echo nl2br($_REQUEST['footer']); ?>
	</div>
	
	<div class="page"></div>
	
	<div id="solution">
	<p>ĐÁP ÁN</p>
	<?=$solution?>
	</div>
</div>
</html>