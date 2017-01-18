<?php 
$limit = 3;
$count = 0;
$mediumJSON = curl("https://medium.com/@ITSriodejaneiro/latest?format=json");
$youtubeJSON = curl("https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=".YOUTUBE_ID."&key=".YOUTUBE_KEY);

$medium = json_decode(str_replace('])}while(1);</x>', '', $mediumJSON))->payload->references->Post;
$youtube = json_decode($youtubeJSON);
?>
<div class="social-content show-for-medium column medium-9 large-offset-1">
	<div class="articles latest">
		<p><b><?= pll__('últimos artigos (Medium)') ?></b></p>
		<ul>
			<?php
			foreach ($medium as $post) {
				if($count >= $limit)
					break;
				$count++;
				?>
				<li><a target="_blank" href="https://feed.itsrio.org/<?= $post->slug.'-'.$post->id ?>"><?= $post->title ?></a></li>
				<?php
			}
			?>
		</ul>
	</div>

	<div class="videos latest">
		<p><b><?= pll__('últimos vídeos (YouTube)') ?></b></p>
		<ul>
			<?php 
			$count = 0;
			foreach($youtube->items as $post){
				if($count >= $limit)
					break;
				$count++;
				?>
				<li>
					<a target="_blank" href="https://youtube.com/watch?v=<?= $post->id->videoId ?>">
						<?= $post->snippet->title ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>

	<div class="tags latest">
		<p><b><?= pll__('#trending tags') ?></b></p>
		<p class="desc"></p>
		<?php do_shortcode(wpp_get_mostpopular(array(
		'post_type' => 'cursos_ctp,varandas_ctp,publicacoes_ctp,projetos_ctp',
		'limit'		=> '3',
		'range'		=> 'weekly',
		'post_html' => '<li><a href="{url}">{title}</a></li>'
		)));
	 ?>
	</div>
</div>