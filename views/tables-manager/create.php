<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Add table'; 
?>
<h4><?= $this->title ?></h4>

<?php $form = ActiveForm::begin([
        'id' => 'add-table-form',
        'fieldConfig' => [
            'template' => "<div class=\"row\"><div class=\"col-lg-2\">{label}</div><div class=\"col-lg-3\">{input}</div><div class=\"col-lg-7\">{error}</div></div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'database_name')->textInput() ?>
		
		<?= $form->field($model, 'regeneration_job_id')->dropdownList($jobs) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>





