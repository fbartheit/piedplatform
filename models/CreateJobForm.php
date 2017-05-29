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
class CreateJobForm extends Model
{
	public $id;
    public $name;
    public $description;
	public $type;
	public $java_spark_script_location;
	public $java_spark_script_name;
	public $java_spark_default_parameter_value;
	public $php_script_url;
	public $parameters;
	
	public static $types = [['id' => 'JAVA_SPARK_JOB', 'name' => 'JAVA_SPARK_JOB' ],
							['id' => 'PHP_SYNC_JOB', 'name' => 'PHP_SYNC_JOB' ], 
							['id' => 'HYBRID', 'name' => 'HYBRID' ] ];
							
	public static $parameter_types = [['id' => 'NONE', 'name' => 'NONE' ],
							['id' => 'DATE', 'name' => 'DATE' ],
							['id' => 'DATE_RANGE', 'name' => 'DATE_RANGE' ], 
							['id' => 'DATE_HOUR', 'name' => 'DATE_HOUR' ], 
							['id' => 'DATE_HOUR_RANGE', 'name' => 'DATE_HOUR_RANGE' ], 
							['id' => 'STRING_PARAMS', 'name' => 'STRING_PARAMS' ],
							['id' => 'DATE_AND_STRING', 'name' => 'DATE_AND_STRING' ],
							['id' => 'DATE_HOUR_AND_STRING', 'name' => 'DATE_HOUR_AND_STRING' ] ];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type', 
			'java_spark_script_location', 'java_spark_script_name', 
			'java_spark_default_parameter_value', 'php_script_url', 
			'parameters'], 'required']
        ];
    }
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function setJobType($type){
		$this->type = $type;
	}
	
	public function setSparkScriptLocation($java_spark_script_location){
		$this->java_spark_script_location = $java_spark_script_location;
	}
	
	public function setJavaSparkScriptName($java_spark_script_name){
		$this->java_spark_script_name = $java_spark_script_name;
	}
	
	public function setJavaSparkDefaultParameterValue($java_spark_default_parameter_value){
		$this->java_spark_default_parameter_value = $java_spark_default_parameter_value;
	}
	
	public function setPhpScriptUrl($php_script_url){
		$this->php_script_url = $php_script_url;
	}
	
	public function setParameters($parameters){
		$this->parameters = $parameters;
	}
}
?>