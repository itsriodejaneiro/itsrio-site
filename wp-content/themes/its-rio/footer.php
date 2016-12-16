</div>
<footer>
	<div class="row">
		<div class="column large-3">
			<p class="raleway"><?= html_entity_decode(esc_attr( get_option('footer_description') )) ?></p>
			<ul>
				<li><a href="#" class="box">equipe</a></li>
				<li><a href="#" class="box">onde estivemos</a></li>
				<li><a href="#" class="box">comunicados</a></li>
			</ul>
		</div>

		<div class="column large-9">
			<div class="contact-wrapper">
				<div class="contact">
					<b>contatos:</b><br>
					<?= esc_attr(get_option('footer_contacts')) ?>
				</div>
				<input type="text" placeholder="escreva seu email para receber nossa newsletter" class="newsletter-input">
				<a href="#" class="box newsletter-button">inscreva-se</a>
			</div>
		</div>
		<?php include 'latest-social-content.php'; ?>
	</div>
	<div class="row">
		<div class="column large-3"><small>desenvolvido por <a href="#">Hacklab</a></small></div>
		<div class="column large-9 raleway">
			<img src="<?= get_template_directory_uri() ?>/assets/images/cc-footer.png" alt="Licença CC BY 3.0 BR" class="creative-commons">
			<?= esc_attr( get_option('footer_adress') ); ?>	
		</div>
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

<style>
	.carousel-cell {
		height: 450px;
		width: 100%;
	}
	.highlights-carousel{
		height: 450px;
		width: 100%;
	}

	.flickity-slider {
		transform: none !important;
	}

	.carousel-cell {
		left: 0 !important;
		opacity: 0;
		transition: opacity 0.6s ease-in-out;
		z-index: -1;
	}

	.carousel-cell.is-selected {
		opacity: 1;
		z-index: 0
	}
</style>
</body>
</html>
