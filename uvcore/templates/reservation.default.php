<?php
	$uvrestypeopendaysscript = uv_get_restypeopendays_script($id);
?>

<div class="uv-integration uv-reservation">
	<div class='uv-panel uv-reservationpanel'>
		<div class='uv-panelbody uv-clearfix'>
			<?php
				$uveventform = uv_get_formhtml("", $id);
				echo($uveventform);
			?>
		</div>
	</div>
	
	<a class="uv-pwby-lb" href="http://urvenue.com" target="_blank"></a>
</div>

<script>
	uv_resopendays["r<?=$id;?>"] = Array();
	uv_resopendays["r<?=$id;?>"] = <?=$uvrestypeopendaysscript;?>;
</script>