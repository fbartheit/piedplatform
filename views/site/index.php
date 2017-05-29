<?php

/* @var $this yii\web\View */
use app\widgets\module_select_widget\ModuleSelectWidget;

$this->title = 'Pied Piper - Home';
?>
<div class="site-index">
	<div class="container">
		<?php
			$modules = Yii::$app->params['platformModules'];
			$numModules = count($modules);
			for($i=0; $i<$numModules; $i++){ ?>
				<?= ModuleSelectWidget::widget([
						'name' => $modules[$i]['name'],
						'iconClass' => $modules[$i]['iconClass'],
						'controller' => $modules[$i]['controller']
				]) ?>
		<?php } ?>
	</div>
</div>
