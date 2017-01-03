</div>
<footer>
	<div class="row">
		<div class="column large-2">
			<p class="raleway"><?= html_entity_decode(esc_attr( get_option('footer_description') )) ?></p>
			<ul>
				<li><a href="#" class="box">equipe</a></li>
				<li><a href="#" class="box">onde estivemos</a></li>
				<li><a href="#" class="box">comunicados</a></li>
			</ul>
		</div>

		<div class="column large-9 large-offset-1">
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
<script src="https://cdn.jsdelivr.net/lodash/4.17.2/lodash.min.js"></script>
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

.flickity-slider .carousel-cell {
		left: 0 !important;
		opacity: 0;
		transition: opacity 0.6s ease-in-out;
		z-index: -1;
	}

.flickity-slider .carousel-cell.is-selected {
		opacity: 1;
		z-index: 0
	}
</style>
<script type="text/javascript">
			
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});

					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text('Gender: ' + obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.single-header-dropdown').removeClass('active');
				});

			});
			
		</script>
</body>
</html>
