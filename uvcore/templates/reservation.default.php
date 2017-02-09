<?php
	$uvrestypeopendaysscript = uv_get_restypeopendays_script($id);
?>

<div class="uv-integration">
	<div class='uv-panel uv-reservationpanel'>
		<div class='uv-panelbody uv-clearfix'>
			<?php
				$uveventform = uv_get_formhtml("", $id);
				echo($uveventform);
			?>
		</div>
	</div>
</div>

<script>
	uv_resopendays["r<?=$id;?>"] = Array();
	uv_resopendays["r<?=$id;?>"] = <?=$uvrestypeopendaysscript;?>;
</script>