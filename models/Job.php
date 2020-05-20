<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $name
 * @property string $begin
 * @property string $end
 * @property int $activity_id
 * @property int $status_id
 *
 * @property Activity $activity
 * @property Status $status
 * @property Timesheet[] $timesheets
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'begin', 'end', 'activity_id', 'status_id'], 'required'],
            [['begin', 'end'], 'safe'],
            [['activity_id', 'status_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'begin' => 'Дата начала',
            'end' => 'Дата окончания',
            'activity_id' => 'Активность',
            'status_id' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Activity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Timesheets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimesheets()
    {
        return $this->hasMany(Timesheet::className(), ['job_id' => 'id']);
    }
}
