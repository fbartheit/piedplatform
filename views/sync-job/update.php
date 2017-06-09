<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SyncJob */

$this->title = 'Update Sync Job: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sync Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sync-job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
