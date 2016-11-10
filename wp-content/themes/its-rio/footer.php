</div>
<?php global $data; ?>
<script>
	'use strict';

	let vue = new Vue({
		el : '#content',
		data : <?= json_encode($data) ?>
	});
</script>

</body>
</html>
