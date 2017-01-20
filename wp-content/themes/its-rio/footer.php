<?php global $data; global $components; global $postType; global $lang; ?>
</div>
<footer>
	<div class="row">
		<div class="social-icons column small-12 show-for-small-only">
			<h3><?= pll__('ITS nas redes') ?></h3>
			<div class="line"></div>
			<ul>
				<li>
					<a href="https://www.youtube.com/user/ITSriodejaneiro" target="_blank"><i class="fa fa-youtube-play"></i></a>
				</li>
				<li>
					<a href="https://twitter.com/itsriodejaneiro" target="_blank"><i class="fa fa-twitter"></i></a>
				</li>
				<li>
					<a href="https://www.facebook.com/ITSriodejaneiro" target="_blank"><i class="fa fa-facebook"></i></a>
				</li>
				<li>
					<a href="https://www.instagram.com/itsriodejaneiro/" target="_blank"><i class="fa fa-instagram"></i></a>
				</li>
				<li>
					<a href="https://feed.itsrio.org" target="_blank"><i class="fa fa-medium"></i></a>
				</li>
				<li>
					<a href="https://github.com/itsriodejaneiro" target="_blank"><i class="fa fa-github"></i></a>
				</li>
			</ul>
		</div>

		<div class="column small-12 show-for-small-only">
			<b>newsletter:</b><br>
			<input type="text" id="txtNewsletter_Mobile" placeholder="escreva seu email para receber" class="newsletter-input">
			<a href="javascript:void(0);" class="box newsletter-button" onclick="openNewsletter()"><?= pll__('inscreva-se') ?></a>
		</div>

		<div class="column medium-2">
			<p class="raleway"><?= html_entity_decode(esc_attr(get_option('footer_description'))) ?></p>
			<ul>
				<li><a href="/<?= $lang ?>/institucional/#equipe" class="box" onclick="if($('body').hasClass('page-id-35')) window.location.reload();"><?= pll__('equipe') ?></a></li>
				<li><a href="/<?= $lang ?>/institucional/#onde-estivemos" class="box show-for-large" onclick="if($('body').hasClass('page-id-35')) window.location.reload();"><?= pll__('onde estivemos') ?></a></li>
				<li><a href="/<?= $lang ?>/institucional/#comunicados" class="box" onclick="if($('body').hasClass('page-id-35')) window.location.reload();"><?= pll__('comunicados') ?></a></li>
			</ul>
		</div>

		<div class="column medium-9 medium-offset-1 show-for-medium">
			<div class="contact-wrapper">
				<div class="contact">
					<b><?= pll__('contatos:') ?></b><br>
					<?= esc_attr(get_option('footer_contacts')) ?>
				</div>
				<div class="newsletter">
					<b>newsletter:</b><br>
					<input type="text" id="txtNewsletter" placeholder="escreva seu email para receber" class="newsletter-input">
				</div>
				<a href="javascript:void(0);" class="box newsletter-button" onclick="openNewsletter()"><?= pll__('inscreva-se') ?></a>
			</div>
		</div>
		<?php include ROOT.'inc/latest-social-content.php'; ?>
	</div>
	<div class="row">
		<div class="column medium-9 medium-push-3 raleway">
			<img src="<?= get_template_directory_uri() ?>/assets/images/cc-footer.png" alt="Licença CC BY 3.0 BR" class="creative-commons">
			<?= esc_attr(get_option('footer_adress')); ?>
		</div>
		<div class="column medium-3 medium-pull-9 "><small><?= pll__('desenvolvido por') ?> <a href="#">Hacklab/</a></small></div>
	</div>
</footer>
</div>

<div class="reveal-overlay">
	<div id="modalNewsletter" class="reveal-modal" data-reveal="rqhkrl-reveal" aria-labelledby="modalTitle" aria-hidden="true" role="dialog" data-yeti-box="modalNewsletter" data-resize="modalNewsletter">
		<iframe src="" frameborder="0" width="100%" height="100%"></iframe>
		<span class="close" onclick="$('.reveal-overlay').fadeOut();">&times;</span>
	</div>
</div>

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
	var post_type = '<?= ($postType == 'page') ? $_SERVER["REQUEST_URI"] :  $postType  ?>';
	var lang = '<?= $lang ?>';
</script>
<script src="/wp-content/themes/its-rio/assets/js/its.js"></script>
<script src="/wp-content/themes/its-rio/assets/js/plugins.js"></script>

<script type="text/javascript">
	function toggleMenu(){
		if($('.menu-nav').hasClass('active')){
			$('html,body').css('overflow-y','');
			$('html,body').css('position','');
		}else{
			$('html,body').css('position','relative');
			$('html,body').css('overflow-y','hidden');
		}

		$('.menu-nav').toggleClass('active');
		$('.menu-nav-bg').fadeToggle();
	}

	function openBuscaAvancada() {
		$('.filter-options,.advanced-search').toggleClass('active');
		setTimeout(function(){
			$('#cat-filter').customScrollbar({  skin: "default-skin" });
		},500);
	}

	function openNewsletter(){
		$('.reveal-overlay').fadeIn();
		$('#modalNewsletter iframe').attr('src','http://itsrio.us12.list-manage2.com/subscribe?u=b2433258ec47fc6f9a063fd7b&id=8a308c4e7a&MERGE0='+$('#txtNewsletter').val());
	}

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
		}
	}

	$(function() {
		var dd = new DropDown( $('.single-header-drop-down') );
		$(document).click(function() {
			$('.single-header-drop-down').removeClass('active');
		});
	});
</script>
<?php //wp_footer();?>
</body>
</html>
