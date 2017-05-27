<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dish_ingr".
 *
 * @property integer $id
 * @property integer $dish_id
 * @property integer $ingr_id
 *
 * @property Dish $dish
 * @property Ingr $ingr
 */
class dish_ingr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish_ingr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dish_id', 'ingr_id'], 'integer'],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dish::className(), 'targetAttribute' => ['dish_id' => 'id']],
            [['ingr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingr::className(), 'targetAttribute' => ['ingr_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dish_id' => 'Dish ID',
            'ingr_id' => 'Ingr ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dish::className(), ['id' => 'dish_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngr()
    {
        return $this->hasOne(Ingr::className(), ['id' => 'ingr_id']);
    }
}
