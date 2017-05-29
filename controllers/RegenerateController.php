<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\Database;
use yii\data\ArrayDataProvider;
use yii\web\View;

class RegenerateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['javasparkjob', 'php-job'],
                'rules' => [
                    [
                        'actions' => ['javasparkjob', 'php-job'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionJavasparkjob($id)
    {
		//Database::updateRegenerationStatus($id, 'SPARK_JAVA_PART_IN_PROGRES');
		$output = shell_exec(dirname(__FILE__) . '/../bash_scripts/script.sh $id SPARK_JAVA_PART_IN_PROGRES &> /dev/null &');
		$response = [];
		$response['status'] = 'true';
        return json_encode($response);
    }
	
	public function actionJavaSparkJobGetStatusUpdate($id){
		$regeneration = Database::getRegenerationStatus($id);
		$status = $regeneration['status'];
		$response = [];
		$response['status'] = 'true';
		$response['job_status'] = $status;
		return json_encode($response);
	}
	
	/**
     * Displays homepage.
     *
     * @return string
     */
    public function actionPhpJob()
    {
		/* TODO update job extraction also by database */
		$regeneration_job = Database::getRegenerationJobForAlert($id);
		$affected_values = explode(',', $regeneration_job['affected_values']);
		Yii::$app->view->registerJs(
			"$('#regenerate_parameter_date_time_from').flatpickr({
				" . (($regeneration_job['parameters'] == 'DATE_HOUR'
					|| $regeneration_job['parameters'] == 'DATE_HOUR_RANGE'
					|| $regeneration_job['parameters'] == 'DATE_HOUR_AND_STRING')?'enableTime: true':'') . "
			});
			
			$('#regenerate_parameter_date_time_to').flatpickr({
				". (($regeneration_job['parameters'] == 'DATE_HOUR'
					|| $regeneration_job['parameters'] == 'DATE_HOUR_RANGE'
					|| $regeneration_job['parameters'] == 'DATE_HOUR_AND_STRING')?'enableTime: true':'') . "
			});",
			View::POS_READY,
			'regeneration-datepicker-setup-script'
		);
        return $this->render('regenerate', [
			'rj' => $regeneration_job,
			'av' => $affected_values
		]);
    }
	
}
?>