</div>
<?php global $data; global $aulas; ?>
<script>
	'use strict';

	Vue.component('its-aulas', {
		data(){
			return { 'aulas' : <?= json_encode($aulas) ?> };
		}
	});

	let vue = new Vue({
		el : '#content',
		data : <?= json_encode($data) ?>
	});
</script>

</body>
</html>
