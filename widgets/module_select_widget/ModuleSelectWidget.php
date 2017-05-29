<?php 

namespace app\widgets\module_select_widget;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class ModuleSelectWidget extends Widget
{
    public $name;
	public $iconClass;
	public $controller;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
		$model = [];
		$model['name'] = $this->name;
		$model['iconClass'] = $this->iconClass;
		$model['controller'] = Url::to([$this->controller.'/']);
        return $this->render('index', ['model' => $model]);
    }
}

?>