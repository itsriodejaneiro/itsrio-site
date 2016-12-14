<?php
if ($query->have_posts() ) {
	while( $query->have_posts() ) {
		$query->the_post();
		include(ROOT . 'inc/post-box.php');
	}
}
?>