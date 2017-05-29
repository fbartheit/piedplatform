<?php 

namespace app\widgets\module_actions_widget;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class ModuleActionsWidget extends Widget
{
    public $title;
	public $controller;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('index', ['title' => $this->title, 'controller' => $this->controller]);
    }
}

?>