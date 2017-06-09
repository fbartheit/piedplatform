<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SyncJobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sync Jobs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sync-job-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sync Job', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description:ntext',
            'rank',
            'active',
            // 'last_changed',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',  // the default buttons + your custom button
			]
        ],
    ]); ?>
</div>
