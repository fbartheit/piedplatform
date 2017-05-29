<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\Database;
use yii\data\ArrayDataProvider;
use app\models\CreateJobForm;
use yii\helpers\ArrayHelper;

class JobsManagerController extends Controller
{	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update'],
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
    public function actionIndex($detailed = false)
    {
        $jobs = Database::getAllRegenerationJobs();
		$dataProvider = new ArrayDataProvider([
			'allModels' => $jobs,
			'pagination' => ['pageSize' => 20]
		]);
        return $this->render('index', [
			'dataProvider' => $dataProvider,
			'detailed' => $detailed
		]);
    }
	
	public function actionCreate()
    {
		$model = new CreateJobForm();
        if($model->load(Yii::$app->request->post())){
			Database::insertRegenerationJob($model);
			return $this->redirect(['jobs-manager/index']);
		}
		
		$allowed_types = ArrayHelper::map(CreateJobForm::$types, 'id', 'name');
		$parameter_types = ArrayHelper::map(CreateJobForm::$parameter_types, 'id', 'name');
		
        return $this->render('create', [
            'model' => $model,
			'types' => $allowed_types,
			'parameter_types' => $parameter_types
        ]);
    }
	
	public function actionUpdate($id)
    {
		$model = new CreateJobForm();
        if($model->load(Yii::$app->request->post())){
			$model->setId($id);
			Database::updateJob($model);
			return $this->redirect(['jobs-manager/index']);
		}
		$job = Database::getJobById($id);
		$model->setId($job['id']);
		$model->setName($job['name']);
		$model->setDescription($job['description']);
		$model->setJobType($job['type']);
		$model->setSparkScriptLocation($job['java_spark_script_location']);
		$model->setJavaSparkScriptName($job['java_spark_script_name']);
		$model->setJavaSparkDefaultParameterValue($job['java_spark_default_parameter_value']);
		$model->setPhpScriptUrl($job['php_script_url']);
		$model->setParameters($job['parameters']);
		
		$allowed_types = ArrayHelper::map(CreateJobForm::$types, 'id', 'name');
		$parameter_types = ArrayHelper::map(CreateJobForm::$parameter_types, 'id', 'name');
		
        return $this->render('update', [
            'model' => $model,
			'types' => $allowed_types,
			'parameter_types' => $parameter_types
        ]);
    }
	
}
?>