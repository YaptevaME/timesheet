<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $is_read
 * @property int $employee_id
 *
 * @property Employee $employee
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_read', 'employee_id'], 'required'],
            [['is_read', 'employee_id'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_read' => 'Is Read',
            'employee_id' => 'Employee ID',
        ];
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
