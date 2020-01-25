<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "dialogdetail".
 *
 * @property int $id
 * @property string $word
 * @property string $translation
 * @property int $category_id
 * @property string $last_update
 * @property int $count
 *
 * @property Category $category
 */
class Dialogdetail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialogdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dialog_id', 'count', 'step'], 'integer'],
            [['last_update'], 'safe'],
            [['dialog', 'translation'], 'string', 'max' => 500],
            [['dialog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dialogname::className(), 'targetAttribute' => ['dialog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dialog' => 'Dialog',
            'step' => 'Step',
            'translation' => 'Translation',
            'dialog_id' => 'Dialog ID',
            'last_update' => 'Last Update',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogname()
    {
        return $this->hasOne(DialogName::className(), ['id' => 'dialog_id']);
    }
}