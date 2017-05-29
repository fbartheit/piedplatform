<?php 
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CreateTableForm extends Model
{
	public $id;
    public $name;
    public $database_name;
	public $regeneration_job_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'database_name', 'regeneration_job_id'], 'required']
        ];
    }
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setDatabaseName($database_name){
		$this->database_name = $database_name;
	}
	
	public function setRegenerationJobId($regeneration_job_id){
		$this->regeneration_job_id = $regeneration_job_id;
	}
}
?>