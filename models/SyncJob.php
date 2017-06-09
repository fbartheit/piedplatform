<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sync_job".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property double $rank
 * @property integer $active
 * @property string $last_changed
 *
 * @property SyncStep[] $syncSteps
 */
class SyncJob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sync_job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['rank'], 'required'],
            [['rank'], 'number'],
            [['active'], 'integer'],
            [['last_changed'], 'safe'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'rank' => 'Rank',
            'active' => 'Active',
            'last_changed' => 'Last Changed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyncSteps()
    {
        return $this->hasMany(SyncStep::className(), ['job_id' => 'id']);
    }
}
