<div class="wrap">
    <h2>Limit Post Titles</h2>
    <form method="post" action="options.php">
    	<?php
    		 settings_fields('sr_title_group');
    		 do_settings_sections('sr_limiter');
    		 submit_button();
    	?>
    </form>
</div>
