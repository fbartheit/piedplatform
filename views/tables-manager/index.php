<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\module_actions_widget\ModuleActionsWidget;

$this->title = 'Tables Manager';
?>
<?= ModuleActionsWidget::widget(['title' => $this->title, 'controller' => 'tables-manager']) ?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		/*'table_id',*/ // make this column invisible
		'table_name',
		'database_name',
		'regeneration_job_name',
		[
			'class' => 'yii\grid\ActionColumn',
            'template' => '{btnUpdate}',  // the default buttons + your custom button
            'buttons' => [
                'btnUpdate' => function($url, $model, $key) {     // render your custom button
                    return Html::a(
						'Update', 
						[
							'tables-manager/update', 
							'id' => $model['table_id']							
						], 
						['class' => 'btn btn-success btn-xs']
					);
                }
            ]
		]
	]
]) ?>