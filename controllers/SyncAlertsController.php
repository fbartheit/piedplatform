<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\Database;
use yii\data\ArrayDataProvider;
use yii\web\View;

class SyncAlertsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'regenerate'],
                'rules' => [
                    [
                        'actions' => ['index', 'regenerate'],
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
    public function actionIndex()
    {
		$alerts = Database::getSyncAlertsNotRegenerated();
		$dataProvider = new ArrayDataProvider([
			'allModels' => $alerts,
			'pagination' => ['pageSize' => 20]
		]);
        return $this->render('index', [
			'dataProvider' => $dataProvider
		]);
    }
	
	/**
     * Displays homepage.
     *
     * @return string
     */
    public function actionRegenerate($id, $affected_table)
    {
		/* TODO update job extraction also by database */
		$regeneration_jobs = Database::getRegenerationJobForAlert($id);
		$regeneration_job = $regeneration_jobs[0];
		$affected_values = explode(',', $regeneration_job['affected_values']);
		$dataProvider = new ArrayDataProvider([
			'allModels' => $regeneration_jobs,
			'pagination' => ['pageSize' => 40]
		]);
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
			'dataProvider' => $dataProvider,
			'av' => $affected_values
		]);
    }
	
	public function actionAddSyncAlert($database, $table, $type, $values){
		$alert = [];
		$alert['database'] = $database;
		$alert['table'] = $table;
		$alert['type'] = $type;
		$alert['values'] = $values;
		Database::insertAlert($alert);
		return 'true';
	}
	
}
?>