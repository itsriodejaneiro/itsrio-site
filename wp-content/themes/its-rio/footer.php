</div>
<footer>
	<div class="column large-3">
		<p class="raleway"><?= html_entity_decode(esc_attr( get_option('footer_description') )) ?></p>
		<ul>
			<li><a href="#" class="box">equipe</a></li>
			<li><a href="#" class="box">onde estivemos</a></li>
			<li><a href="#" class="box">comunicados</a></li>
		</ul>
	</div>

	<div class="column large-3">
		<p class="contact"><b>contatos:</b><br>
		<?= esc_attr(get_option('footer_contacts')) ?></p>
	</div>

	<div class="column large-6">
		<input type="text" placeholder="newsletter">
		<a href="#" class="box">inscreva-se</a>
		<br>
		<br>
		<br>
	</div>
	<?php include 'latest-social-content.php'; ?>
	<div style="overflow: hidden; clear: both">
		<div class="column large-3"><small>desenvolvido por <a href="#">Hacklab</a></small></div>
		<div class="column large-9 raleway"><?= esc_attr( get_option('footer_adress') );  ?></div>
	</div>
</footer>
</div>

<?php global $data; global $components; global $postType; ?>

<script>
	<?php 
	foreach ($components as $variable => $value) {
		?>
		var <?= $variable ?> = <?= json_encode($value) ?>;
		<?php
	}
	$markers = file_get_contents(ROOT.'/functions/components/map/markers.json');
	?>

	var markers = <?= !is_null($markers) && $markers != '' ? $markers : '[]' ?>;
	var site_data =  <?= json_encode($data) ?>;
	var post_type = '<?= $postType ?>';
</script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="/wp-content/themes/its-rio/assets/js/its.js"></script>
</body>
</html>
