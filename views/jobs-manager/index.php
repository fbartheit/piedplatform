<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\module_actions_widget\ModuleActionsWidget;

$this->title = 'Regeneration Jobs';
?>
<?= ModuleActionsWidget::widget(['title' => $this->title, 'controller' => 'jobs-manager']) ?>

<?php if($detailed == false){ ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name',
			'description',
			'type',
			'java_spark_script_location',
			'java_spark_script_name',
			/*'java_spark_default_parameter_value',*/
			'php_script_url',
			'parameters',
			[
			'class' => 'yii\grid\ActionColumn',
            'template' => '{btnUpdate}',  // the default buttons + your custom button
            'buttons' => [
                'btnUpdate' => function($url, $model, $key) {     // render your custom button
                    return Html::a(
						'Update', 
						[
							'jobs-manager/update', 
							'id' => $model['id']							
						], 
						['class' => 'btn btn-success btn-xs']
					);
                }
            ]
		]
		]
	]) ?>
<?php }else{ ?>
	<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'name',
		'description',
		'type'
	]
]) ?>
<?php } ?>