<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\module_actions_widget\ModuleActionsWidget;

$this->title = 'Sync Alerts';
?>
<?= ModuleActionsWidget::widget(['title' => $this->title, 'controller' => 'sync-manager']) ?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'date_time',
		'affected_database',
		'affected_table',
		'alert_type',
		'affected_values',
		'regenerated',
		[
			'class' => 'yii\grid\ActionColumn',
            'template' => '{btnRegenerate}',  // the default buttons + your custom button
            'buttons' => [
                'btnRegenerate' => function($url, $model, $key) {     // render your custom button
                    return Html::a(
						'Regenerate', 
						[
							'sync-alerts/regenerate', 
							'id' => $model['id'],							
							'affected_table' => $model['affected_table']							
						], 
						['class' => 'btn btn-success btn-xs', 'target' => '_blank']
					);
                }
            ]
		]
	]
]) ?>