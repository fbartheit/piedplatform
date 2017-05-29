<?php

namespace app\components;

use yii\db\Query;
use Yii;

class Database{
	
	private static $dbTables = [
		'TABLE_SYNC_ALERTS' => 'sync_alerts',
		'TABLE_REGENERATION_JOBS' => 'regeneration_jobs',
		'TABLE_TABLES' => 'tables',
		'TABLE_ALERT_REGENERATIONS' => 'alert_regenerations'
	];
	
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  */
/* TABLES * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	public static function getAllTables(){
		$query = new Query();
		$rows = $query->select('tables.id AS table_id, tables.name AS table_name, tables.database_name, regeneration_jobs.name AS regeneration_job_name')
						->from(Database::$dbTables['TABLE_TABLES'])
						->join('LEFT JOIN', 'regeneration_jobs', 'tables.regeneration_job_id = regeneration_jobs.id')
						->all();
		return $rows;
	}
	
	public static function insertTable($table){
		Yii::$app->db->createCommand()->insert(Database::$dbTables['TABLE_TABLES'], [
			'name' => $table->name,
			'database_name' => $table->database_name,
		])->execute();
	}
	
	public static function updateTable($table){
		Yii::$app->db->createCommand()->update(Database::$dbTables['TABLE_TABLES'], [
			'name' => $table->name,
			'database_name' => $table->database_name,
			'regeneration_job_id' => $table->regeneration_job_id
		], 'id = ' . $table->id)->execute();
	}
	
	public static function getTableById($id){
		$query = new Query();
		$row = $query->select('*')
						->from(Database::$dbTables['TABLE_TABLES'])
						->where('id=:id')
						->addParams([':id' => $id])
						->one();
		return $row;
	}
	
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  */
/* ALERTS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	public static function insertAlert($alert){
		Yii::$app->db->createCommand()->insert(Database::$dbTables['TABLE_SYNC_ALERTS'], [
			'affected_database' => $alert['database'],
			'affected_table' => $alert['table'],
			'alert_type' => $alert['type'],
			'affected_values' => $alert['values']
		])->execute();
		$alert_id = Yii::$app->db->getLastInsertID();
		$values_parts = explode(',', $alert['values']);
		$regenerations = [];
		foreach($values_parts as $vp){
			$reg = [];
			array_push($reg, $alert_id);
			array_push($reg, $vp);
			array_push($regenerations, $reg);
		}
		Yii::$app->db->createCommand()
					->batchInsert(Database::$dbTables['TABLE_ALERT_REGENERATIONS'], ['alert_id', 'date_param'], $regenerations)
					->execute();
	}
	
	public static function getSyncAlertsNotRegenerated(){
		$query = new Query();
		$rows = $query->select('*')
						->from(Database::$dbTables['TABLE_SYNC_ALERTS'])
						->where("regenerated = 'NO'")
						->all();
		return $rows;
	}
	
	public static function getSyncAlertsById($id){
		$query = new Query();
		$row = $query->select('*')
						->from(Database::$dbTables['TABLE_SYNC_ALERTS'])
						->where('id=:id')
						->addParams([':id' => $id])
						->one();
		return $row;
	}
	
	public static function getRegenerationStatus($id){
		$query = new Query();
		$row = $query->select('status')
						->from(Database::$dbTables['TABLE_ALERT_REGENERATIONS'])
						->where('id=:id')
						->addParams([':id' => $id])
						->one();
		return $row;
	}
	
	public static function updateRegenerationStatus($id, $status){
		Yii::$app->db->createCommand()->update(Database::$dbTables['TABLE_ALERT_REGENERATIONS'], [
			'status' => $status
		], 'id = ' . $id)->execute();
	}
	
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  */
/* JOBS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	public static function insertRegenerationJob($job){
		Yii::$app->db->createCommand()->insert(Database::$dbTables['TABLE_REGENERATION_JOBS'], [
			'name' => $job->name,
			'description' => $job->description,
			'type' => $job->type,
			'java_spark_script_location' => $job->java_spark_script_location,
			'java_spark_script_name' => $job->java_spark_script_name,
			'java_spark_default_parameter_value' => $job->java_spark_default_parameter_value,
			'php_script_url' => $job->php_script_url,
			'parameters' => $job->parameters
		])->execute();
	}
	
	public static function getAllRegenerationJobs(){
		$query = new Query();
		$rows = $query->select('*')
						->from(Database::$dbTables['TABLE_REGENERATION_JOBS'])
						->all();
		return $rows;
	}
	
	public static function getRegenerationJobForAlert($alert_id){
		$query = new Query();
		$rows = $query->select('sync_alerts.id AS alert_id,
								sync_alerts.affected_values AS affected_values,
								tables.name AS table_name,
								tables.database_name AS database_name,
								regeneration_jobs.name AS job_name,
								regeneration_jobs.description AS job_description,
								regeneration_jobs.type AS job_type,
								regeneration_jobs.java_spark_script_location,
								regeneration_jobs.java_spark_script_name,
								regeneration_jobs.php_script_url,
								regeneration_jobs.parameters,
								alert_regenerations.id AS regeneration_id,
								alert_regenerations.date_param,
								alert_regenerations.string_param,
								alert_regenerations.status')
					->from(Database::$dbTables['TABLE_SYNC_ALERTS'])
					->join('INNER JOIN', Database::$dbTables['TABLE_TABLES'], 'sync_alerts.affected_table = tables.name')
					->join('INNER JOIN', Database::$dbTables['TABLE_REGENERATION_JOBS'], 'tables.regeneration_job_id = regeneration_jobs.id')
					->join('INNER JOIN', Database::$dbTables['TABLE_ALERT_REGENERATIONS'], 'sync_alerts.id = alert_regenerations.alert_id')
					->where('sync_alerts.id=:id')
					->addParams([':id' => $alert_id])
					->all();
		return $rows;
	}
	
	public static function getJobById($id){
		$query = new Query();
		$row = $query->select('*')
						->from(Database::$dbTables['TABLE_REGENERATION_JOBS'])
						->where('id=:id')
						->addParams([':id' => $id])
						->one();
		return $row;
	}
	
	public static function updateJob($job){
		Yii::$app->db->createCommand()->update(Database::$dbTables['TABLE_REGENERATION_JOBS'], [
			'name' => $job->name,
			'description' => $job->description,
			'type' => $job->type,
			'java_spark_script_location' => $job->java_spark_script_location,
			'java_spark_script_name' => $job->java_spark_script_name,
			'java_spark_default_parameter_value' => $job->java_spark_default_parameter_value,
			'php_script_url' => $job->php_script_url,
			'parameters' => $job->parameters
		], 'id = ' . $job->id)->execute();
	}
}

?>