<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SyncJob */

$this->title = 'Create Sync Job';
$this->params['breadcrumbs'][] = ['label' => 'Sync Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sync-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
