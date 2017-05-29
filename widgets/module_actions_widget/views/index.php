<?php
use yii\helpers\Html;
?>
<div class="container">
	<span class="module_actions_title"><?= $title ?></span>
	<span class="module_actions_buttons">
		<?= Html::a(
			'<span class="glyphicon glyphicon-plus-sign"></span>',
			[
				$controller . '/create'							
			],
			['encode' => false]
		) ?>
	</span>
</div>

<script>

</script>