<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Activity[] $activities
 */
class ActivityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип активности',
        ];
    }

    /**
     * Gets query for [[Activities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['activity_type_id' => 'id']);
    }
}
