<?php  if (count($_SESSION['errors']) > 0) : ?>
	<div class="error">
		<?php foreach ($_SESSION['errors'] as $error) : ?>
			<p><strong><?php echo $error ?></strong></p>
		<?php endforeach ?>
	</div>
<?php  endif ?>
