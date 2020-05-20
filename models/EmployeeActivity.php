<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_activity".
 *
 * @property int $employee_id
 * @property int $activity_id
 *
 * @property Activity $activity
 * @property Employee $employee
 */
class EmployeeActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'activity_id'], 'required'],
            [['employee_id', 'activity_id'], 'integer'],
            [['employee_id', 'activity_id'], 'unique', 'targetAttribute' => ['employee_id', 'activity_id']],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Сотрудник',
            'activity_id' => 'Activity ID',
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
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
}
