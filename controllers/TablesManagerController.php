<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\Database;
use yii\data\ArrayDataProvider;
use app\models\CreateTableForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class TablesManagerController extends Controller
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
    public function actionIndex()
    {
		$tables = Database::getAllTables();
		$dataProvider = new ArrayDataProvider([
			'allModels' => $tables,
			'pagination' => ['pageSize' => 20]
		]);
        return $this->render('index', [
			'dataProvider' => $dataProvider
		]);
    }
	
    public function actionCreate()
    {
		$model = new CreateTableForm();
        if($model->load(Yii::$app->request->post())){
			Database::insertTable($model);
			return $this->redirect(['tables-manager/index']);
		}
		$r_jobs = ArrayHelper::map(Database::getAllRegenerationJobs(), 'id', 'name');
        return $this->render('create', [
            'model' => $model,
			'jobs' => $r_jobs,
        ]);
    }
	
	public function actionUpdate($id)
    {
		$model = new CreateTableForm();
        if($model->load(Yii::$app->request->post())){
			$model->setId($id);
			Database::updateTable($model);
			return $this->redirect(['tables-manager/index']);
		}
		$table = Database::getTableById($id);
		$model->setId($table['id']);
		$model->setName($table['name']);
		$model->setDatabaseName($table['database_name']);
		$model->setRegenerationJobId($table['regeneration_job_id']);
		$r_jobs = ArrayHelper::map(Database::getAllRegenerationJobs(), 'id', 'name');
        return $this->render('create', [
            'model' => $model,
			'jobs' => $r_jobs,
        ]);
    }
	
}
?>