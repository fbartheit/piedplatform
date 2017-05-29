<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Add job'; 
?>
<h4><?= $this->title ?></h4>

<?php $form = ActiveForm::begin([
        'id' => 'add-job-form',
        'fieldConfig' => [
            'template' => "<div class=\"row\"><div class=\"col-lg-2\">{label}</div><div class=\"col-lg-3\">{input}</div><div class=\"col-lg-7\">{error}</div></div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'description')->textInput() ?>
		
		<?= $form->field($model, 'type')->dropdownList($types) ?>
		
		<?= $form->field($model, 'java_spark_script_location')->textInput() ?>
		
		<?= $form->field($model, 'java_spark_script_name')->textInput() ?>
		
		<?= $form->field($model, 'parameters')->dropdownList($parameter_types) ?>
	
		<?= $form->field($model, 'java_spark_default_parameter_value')->textInput() ?>
		
		<?= $form->field($model, 'php_script_url')->textInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>





