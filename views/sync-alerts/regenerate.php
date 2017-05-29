<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
$this->title = 'Regenerate data'; 
?>
<strong>Affected Database:</strong> <?= $rj['database_name'] ?>
<br/>
<strong>Affected Table:</strong> <?= $rj['table_name'] ?>
<br/>
<strong>Affected Values:</strong> <?= $rj['affected_values'] ?>
<br/>
<strong>Job: </strong> <?= $rj['job_name'] ?> (<i><?= $rj['job_description'] ?></i>)
<br/>
<strong>Job Type:</strong> <?= $rj['job_type'] ?>
<br/>
<strong>Parameters:</strong> <?= $rj['parameters'] ?>
<br/>
<!-- JAVA SPARK PART -->
<?php if($rj['job_type'] == 'JAVA_SPARK_JOB' || $rj['job_type'] == 'HYBRID'){ ?>
<hr/>
<h4>Java Spark Part</h4>
<br/>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'java_spark_script_location',
		'java_spark_script_name',
		'date_param',
		'string_param',
		'status',
		[
			'class' => 'yii\grid\ActionColumn',
            'template' => '{btnStart}',  
            'buttons' => [
                'btnStart' => function($url, $model, $key) {     // render your custom button
                    return $model['status'] == 'NOT_REGENERATED' ? Html::a(
						'Start',
						[
							'regenerate/javasparkjob'
						], 
						[
							'title' => Yii::t('yii', 'Start'),
							'onclick' => "$.ajax({
								type     :'POST',
								cache    : false,
								url  : '".Url::to(['regenerate/javasparkjob', 'id' => $model['regeneration_id']])."',
								success  : function(response) {
									let data = JSON.parse(response);
									let status = data.status;
									if(status == 'true'){
										let r_id = ".$model['regeneration_id'].";
										let counter = 0;
										let sjjChecker = setInterval(function(){
											$.ajax({
												type     :'POST',
												cache    : false,
												url  : '".Url::to(['regenerate/java-spark-job-get-status-update', 'id' => $model['regeneration_id']])."',
												success  : function(response) {
													let data = JSON.parse(response);
													let status = data.status;
													if(status == 'true'){
														let job_status = data.job_status;
														if(job_status == 'SPARK_JAVA_PART_FINISHED'){
															clearInterval(sjjChecker);
															let rowChildren = $(" . '"' . "tr[data-key='".$key. "']" . '"' .").children();
															let numColumns = rowChildren.length;
															rowChildren[numColumns-2].text('SPARK_JAVA_PART_FINISHED');
														}														
													}
												}
											});
										}, 15000);
									}
								}
								});return false;",
							'class' => 'btn btn-success btn-xs'
						]
					) : '';
                }
            ]
		]
	]
]) ?>
<?php } ?>
<?= Html::a('Run all',Url::to(['regenerate/javasparkjob']), [
'title' => Yii::t('yii', 'Run all'),
    'onclick'=>"$.ajax({
    type     :'POST',
    cache    : false,
    url  : '".Url::to(['regenerate/javasparkjob', 'id' => $rj['alert_id']])."',
    success  : function(response) {
        var sjjChecker = function(){};
    }
    });return false;",
	'class' => 'btn btn-success'
                ]); ?>
<!-- PHP SYNC PART -->
<?php if($rj['job_type'] == 'PHP_SYNC_JOB' || $rj['job_type'] == 'HYBRID'){ ?>
<hr/>
<h4>Php Sync Part</h4>
<strong>Script URL:</strong> <a href='http://<?= $rj['php_script_url'] ?>'><?= $rj['php_script_url'] ?></a>
<br/>
<br/>
<br/>
<?php } ?>
<div class="row">
	<div class="col-md-3">
		<input id="regenerate_parameter_date_time_from" class="form-control" />
	</div>
	<div class="col-md-3">
		<input id="regenerate_parameter_date_time_to" class="form-control" />
	</div>
</div>


<!-- cd <?= $rj['java_spark_script_location'] ?>; 
<?php for($i=0; $i<count($av); $i){ ?>
<br/>./<?php 
echo $rj['java_spark_script_name'] . ' ';
if(strpos($rj['parameters'], 'DATE') > -1){ 
	echo ((strpos($rj['parameters'], 'HOUR') > -1) ? 
			date('Y-m-d H', strtotime($av[$i])):
			date('Y-m-d', strtotime($av[$i]))); 
} ?>
<?= ((strpos($rj['parameters'], 'STRING') > -1) ? ' string_param_here':'') ?> ; 
sleep 2 ; 
<?php $i++;
} ?> -->