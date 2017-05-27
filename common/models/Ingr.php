<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ingr".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $active
 */
class Ingr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['desc', 'active'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'desc' => 'Desc',
            'active' => 'Active',
        ];
    }
}
